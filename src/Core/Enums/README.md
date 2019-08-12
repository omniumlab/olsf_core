#ENUM

## General

- Los recursos que no se nutran de Base de datos serán enums. 
- Los enum serán recursos con una serie de clases que representan un valor del enum de forma estática en lugar de venir de la BD.
- Cada valor del enum (clase) 
  - Tendrá que implementar la clase `Core\Enums\EnumValueInterface`

## Identificadores
- Cada `EnumValueInterface` tendrá un `EnumValueIdentifierInterface`.
  - Este identificador llevará un `name` y un `id`, aunque el `name` es opcional.
  - El `name` siempre debe ir en mayúsculas.  
- Un `id` puede ir directamente en la propia clase.
    - Se usará este caso cuando el objeto se identifique de forma inequívoca con ese id. Por ejemplo, el nivel o la fase son ejemplos claros, porque ambos son secuenciales y el identificador es el propio nombre de la fase, que es el orden numérico de la misma. Para este fin, se usará la clase `Core\Enums\Identifier\EnumValueIdentifier`, que recibe el id y opcionalmente el nombre.   
- En cualquier caso que el `id` no sea evidente y pueda ser elegido de forma arbitraria sin una relación específica con su nombre. Para ello se usará la clase `YamlEnumValueIdentifier`, que recibe el objeto del cual queremos sacar su nombre y el `enumName`, que es el nombre del enum en el que estamos. Los la relación entre nombre e id se almacenarán en el archivo `/app/config/app/enums/(enumName).yml`. La estructura interna de este archivo es similar a esta:

```yaml
      PRIMER_NOMBRE: 1
      OTRO_NOMBRE: 2
      TERCER_NOMBRE: 3
```  
