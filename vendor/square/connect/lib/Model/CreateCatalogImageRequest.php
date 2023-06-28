<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * CreateCatalogImageRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class CreateCatalogImageRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'idempotency_key' => 'string',
        'object_id' => 'string',
        'image' => '\SquareConnect\Model\CatalogObject'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'idempotency_key' => 'idempotency_key',
        'object_id' => 'object_id',
        'image' => 'image'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'idempotency_key' => 'setIdempotencyKey',
        'object_id' => 'setObjectId',
        'image' => 'setImage'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'idempotency_key' => 'getIdempotencyKey',
        'object_id' => 'getObjectId',
        'image' => 'getImage'
    );
  
    /**
      * $idempotency_key A unique string that identifies this CreateCatalogImage request. Keys can be any valid string but must be unique for every CreateCatalogImage request.  See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more information.
      * @var string
      */
    protected $idempotency_key;
    /**
      * $object_id Unique ID of the `CatalogObject` to attach to this `CatalogImage`. Leave this field empty to create unattached images, for example if you are building an integration where these images can be attached to catalog items at a later time.
      * @var string
      */
    protected $object_id;
    /**
      * $image The new `IMAGE`-type `CatalogObject` to be attached to this `CatalogImage`. If the `CatalogObject` already has a `CatalogImage`, this call will overwrite it.
      * @var \SquareConnect\Model\CatalogObject
      */
    protected $image;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["idempotency_key"])) {
              $this->idempotency_key = $data["idempotency_key"];
            } else {
              $this->idempotency_key = null;
            }
            if (isset($data["object_id"])) {
              $this->object_id = $data["object_id"];
            } else {
              $this->object_id = null;
            }
            if (isset($data["image"])) {
              $this->image = $data["image"];
            } else {
              $this->image = null;
            }
        }
    }
    /**
     * Gets idempotency_key
     * @return string
     */
    public function getIdempotencyKey()
    {
        return $this->idempotency_key;
    }
  
    /**
     * Sets idempotency_key
     * @param string $idempotency_key A unique string that identifies this CreateCatalogImage request. Keys can be any valid string but must be unique for every CreateCatalogImage request.  See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more information.
     * @return $this
     */
    public function setIdempotencyKey($idempotency_key)
    {
        $this->idempotency_key = $idempotency_key;
        return $this;
    }
    /**
     * Gets object_id
     * @return string
     */
    public function getObjectId()
    {
        return $this->object_id;
    }
  
    /**
     * Sets object_id
     * @param string $object_id Unique ID of the `CatalogObject` to attach to this `CatalogImage`. Leave this field empty to create unattached images, for example if you are building an integration where these images can be attached to catalog items at a later time.
     * @return $this
     */
    public function setObjectId($object_id)
    {
        $this->object_id = $object_id;
        return $this;
    }
    /**
     * Gets image
     * @return \SquareConnect\Model\CatalogObject
     */
    public function getImage()
    {
        return $this->image;
    }
  
    /**
     * Sets image
     * @param \SquareConnect\Model\CatalogObject $image The new `IMAGE`-type `CatalogObject` to be attached to this `CatalogImage`. If the `CatalogObject` already has a `CatalogImage`, this call will overwrite it.
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
        }
    }
}
