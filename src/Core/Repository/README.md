# REPOSITORIOS

Llamamos repositorio a cualquier clase que tenga acceso a (o contenga) una colección de datos de un tipo y expondrá métodos para recuperar dichos datos según los criterios que sean necesarios en cada caso.

También se encarga de persistir los datos en la Base de Datos o en el lugar donde se deben almacenar. Para ello, expondrá el método o métodos necesarios para realizar esta acción según las necesidades.

Por ejemplo: `ProvincesRepository` sería la encargada de acceder al lugar donde se encuentran las provincias para devolverlas en caso de que se soliciten. Podría exponer, por ejemplo, métodos del tipo `getByCountry` que devolvería las provincias del país solicitado.

También podría exponer un método `add(ProvinceInterface $province)` que almacenará la provincia en la Base de Datos.

Los repositorios deben extender de `Core\Repository\RepositoryInterface`.

Una regla a tener en cuenta es que el repostiorio no debe crear el objeto u objetos que recupere, ni tampoco será el encargado de crear los objetos que va a almacenar. De eso se encarga el [Factory](../Factory/README.md). En la práctica esto significa que no habrá ningún `new` dentro de una clase Factory.

El nombre del repositorio será `(collectionName)Repository`, donde `collectionName` es el nombre de la colección, enum o tabla a la que estamos accediendo. Por ejemplo, `UserRepository`, `CountryRepository`, etc.

El repositorio irá en una carpeta `Repository` dentro de la carpeta donde se encuentre la clase de la que se componga la colección y el factory.  

**¿Por qué no se usa la nomenclatura Query?**

La palabra Query se dejará reservada para, posteriormente, crear respositories genéricos que puedan recibir Queries. Eestas queries tendrán las reglas que leerá e interpretará el repositorio para recuperar los datos.

**¿Cuándo NO se debe crear un repositorio?**

- Si no se encuentra el `collectionName` adecuado o al encontrarlo no hace referencia a una colección real.
- Cuando el nombre de la clase hace referencia a una consulta concreta de una colección o a un subgrupo de una colección y no a la colección completa. Por ejemplo, `ActiveUsersRepository` no sería un repositorio válido porque `Active` hace referencia a un campo dentro de `User`.

**Uso de Query**

Aparte del uso reservado que ha comentado anteriormente, el Query seguirá usándose para referirse a los parámetros recibidos mediante GET en la URL. Así como todas las clases que hagan referencia a ellos.

Por ahora, también se conservará el sufijo de Query para los handlers que lo lleven, ya que aún queda una modificación pendiente que reestructure los handlers usando repositories y los futuros queries que aún están pendientes.

En cualquier otra circunsstancia, el uso de query está reservado y debe evitar usarse, al menos hasta que se formalice su uso en este documento.
