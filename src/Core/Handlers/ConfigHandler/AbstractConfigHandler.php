<?php
/**
 * Created by PhpStorm.
 * User: angro
 * Date: 19/06/2018
 * Time: 21:24
 */

namespace Core\Handlers\ConfigHandler;


use App\User\CurrentUserServiceInterface;
use App\User\UserInterface;
use Core\Auth\Permissions\SubjectWithPermissionsInterface;
use Core\Commands\CommandInterface;
use Core\Config\GlobalConfigInterface;
use Core\Entities\EntityInterface;
use Core\ListValue\BaseListValue;
use Core\Handlers\Handler;
use Core\Output\Responses\HandlerResponseInterface;
use Core\Output\Responses\SuccessHandlerResponse;
use Core\Reflection\Finders\ResourcesFinderInterface;
use Core\Text\TextHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractConfigHandler extends Handler
{
    /**
     * @var \Core\Reflection\Finders\ResourcesFinderInterface
     */
    private $resourcesFinder;
    /**
     * @var \Core\Handlers\ConfigHandler\MenuInterface
     */
    private $menu;
    /**
     * @var string
     */
    private $apiUrlPrefix;

    /** @var GlobalConfigInterface */
    private $globalConfig;

    /** @var CurrentUserServiceInterface */
    private $currentUserService;

    /**
     * Handler constructor.
     *
     * @param \Core\Reflection\Finders\ResourcesFinderInterface $resourcesFinder
     * @param \Core\Handlers\ConfigHandler\MenuInterface $menu
     * @param GlobalConfigInterface $globalConfig
     * @param TextHandlerInterface $textHandler
     * @param CurrentUserServiceInterface $currentUserService
     * @param string $restUrlPrefix
     */
    public function __construct(
        ResourcesFinderInterface $resourcesFinder,
        MenuInterface $menu, GlobalConfigInterface $globalConfig,
        TextHandlerInterface $textHandler,
        CurrentUserServiceInterface $currentUserService,
        string $restUrlPrefix
    )
    {
        parent::__construct("GET", false, $textHandler);
        $this->globalConfig = $globalConfig;

        $this->currentUserService = $currentUserService;
        $this->resourcesFinder = $resourcesFinder;
        $this->menu = $menu;
        $this->apiUrlPrefix = $restUrlPrefix;
    }

    /**
     * @param \Core\Commands\CommandInterface $command
     *
     * @return \Core\Output\Responses\HandlerResponseInterface
     */
    public function handle($command): HandlerResponseInterface
    {
        $this->setup();
        $firstEntity = $this->getFirstEntity();
        $user = $this->currentUserService->getCurrentUser(true);
        $userPermissions = $user->getPermissionList();
        $rolePermissions = $user->getRole()->getPermissionList();


        /** @var \Core\Entities\EntityInterface[] $entities */
        $entities = [];
        foreach ($this->resourcesFinder->getAllResources() as $resource) {
            if ($user->getRole()->getPermissions() !== "superadmin")
                $permissions = $userPermissions !== null ? $userPermissions : $rolePermissions;
            else
                $permissions = null;

            $resourceEntities = $resource->getEntities($permissions);
            $firstEntityPos = $this->checkIfContainsEntity($resourceEntities, $firstEntity);

            if ($firstEntity !== null && $firstEntityPos !== false) {
                array_unshift($entities, $resourceEntities[$firstEntityPos]);
                unset($resourceEntities[$firstEntityPos]);
                $entities = array_merge($entities, $resourceEntities);
            } else {
                $entities = array_merge($entities, $resourceEntities);
            }
        }
        $entities = array_merge($entities, $this->getManualEntities());

        $menu = $this->menu->getMenu($entities);
        $this->configMenu($menu);
        $entities = new BaseListValue(array_values($entities));


        $config = [
            "restPrefixUrl" => $this->getApiUrlPrefix(),
            "entities" => $entities->getValues(),
            "menu" => $menu,
            "available_lang" => $this->globalConfig->getAvailableLang()
        ];

        return new SuccessHandlerResponse(200, $config);
    }

    /**
     * @param array $entities
     * @param string $entityToFind
     * @return bool|int Devuelve false si no encuentra o la posición en el array si lo ha encontrado
     */
    private function checkIfContainsEntity(array $entities, ?string $entityToFind)
    {
        if ($entityToFind !== null) {
            foreach ($entities as $index => $entity) {
                if ($entity->getName() === $entityToFind)
                    return $index;
            }
        }

        return false;
    }

    /**
     * @return EntityInterface[]
     */
    abstract function getManualEntities(): array;

    abstract function configMenu(array &$existentMenu);

    protected function getApiUrlPrefix()
    {
        return $this->apiUrlPrefix;
    }

    protected function getFirstEntity(): ?string
    {
        return null;
    }

    protected function getMenu(): MenuInterface
    {
        return $this->menu;
    }

    protected function getResourcesFinder(): ResourcesFinderInterface
    {
        return $this->resourcesFinder;
    }
}
