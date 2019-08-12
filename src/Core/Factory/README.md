# FACTORY
Un factory es una clase que puede crear objetos, normalmente los recursos o modelos que necesitamos. 

Existen 2 tipos de factory: clase factory y método factory

## Clase Factory

Una clase factory es una clase independiente cuya única finalidad es crear objetos de un tipo. Este eserá el método elegido para objetos que se vayan a crear desde fuera de cualquier sitio, es decir, el objeto será usado en primera instancia por alguna clase. Por ejemplo, por un handler o un servicio. 

### Normas

1. Un Factory debe implementar siempre la interfaz `Core\Factory\FactoryInterface`
2. Debe definirse un método para crear el objeto que esta clase controle. Normalmente este método será llamado `make`. 
   - Debe especificar obligatoriamente como valor de devolución, la interfaz del objeto que se está creando.
   - Debe recibir por parámetros los valores que el objeto necesite obligatoriamente (los que lleve en su constructor).
3. El nombre del factory será `(OriginalClassName)Factory`, donde `OriginalClassName` es el nombre de la clase que se pretende crear. Por ejemplo, si queremos hacer un factory para una clase `User`, su factory sería `UserFactory`
4. Los factories deben ir en una carpeta `Factory` dentro de la misma carpeta donde se encuentre la clase original. 

## Método factory

Un método factory es aquel que, dentro de otra clase, crea un objeto que se usa únicamente a través del objeto padre.

Por ejemplo, una clase Coche tiene dentro un objeto de la clase Motor. El motor no se va a usar si no está en un coche montado, así que no tiene sentido que el motor lo cree alguien que no sea el coche.