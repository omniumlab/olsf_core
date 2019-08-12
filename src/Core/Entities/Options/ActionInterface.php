<?php
/**
 * Created by PhpStorm.
 * User: Practicas
 * Date: 26/10/17
 * Time: 9:58
 */

namespace Core\Entities\Options;


interface ActionInterface
{
    const STYLE_DEFAULT = "default";
    const STYLE_PRIMARY = "primary";
    const STYLE_SUCCESS = "success";
    const STYLE_INFO = "info";
    const STYLE_WARNING = "warning";
    const STYLE_DANGER = "danger";
    const STYLE_LINK = "link";

    /**
     * @return string Visual name for this action.
     */
    public function getVisualName();

    /**
     * @return string The icon class (font-awesome class) of the action
     */
    public function getIcon();

    /**
     * @param string $visualName Visual name for this action.
     *
     * @return $this Current instance for fluid interface
     */
    public function setVisualName($visualName);

    /**
     * @param string $icon Icon class (font-awesome class) of the action
     *
     * @return $this Current instance for fluid interface
     */
    public function setIcon($icon);

    /**
     * @return bool True if the action only have the icon. The Visual name will be in the tooltip. With false, the
     *              visual name will be next to the icon
     */
    public function isOnlyIcon();

    /**
     * @param bool $onlyIcon
     *
     * @return $this Current instance for fluid interface
     */
    public function setOnlyIcon($onlyIcon);

    /**
     * @return string The message to ask the user if he/she wants to do the action
     */
    public function getAskMessage();

    /**
     * @param string $askMessage
     *
     * @return $this Current instance for fluid interface
     */
    public function setAskMessage($askMessage);

    /**
     * @param $style string
     * @return $this Current instance for fluid interface
     */
    public function setStyle($style);

    /**
     * Specify which parameters will be passed to the entity of this action.
     * @param array $params
     * @return $this Current instance for fluid interface
     */
    public function setDynamicParams(array $params);

    /**
     * Specifies the name of the fields added to dynamicParams. It must have the same order.
     *
     * @param string[] $paramsCorrespondences
     * @return $this
     */
    public function setDynamicParamsCorrespondences(array $paramsCorrespondences);

    /**
     * @param string $fieldName
     * @return $this
     */
    public function setVisibilityColumn(string $fieldName);
}
