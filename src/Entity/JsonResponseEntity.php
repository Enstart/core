<?php namespace Enstart\Entity;

use JsonSerializable;

class JsonResponseEntity implements JsonSerializable
{
    /**
     * @var array
     */
    protected $params = [
        'success' => true,
        'data'    => null,
        'errors'  => [],
        'message' => null,
        'code'    => 200,
    ];


    /**
     * @param boolean $success
     * @param mixed   $data
     * @param integer $code
     * @param array   $errors
     * @param string  $message
     */
    public function __construct($success = true, $data = null, $code = 200, array $errors = [], $message = null)
    {
        $this->setSuccess($success);
        $this->setData($data);
        $this->setMessage($message);
        $this->setCode($code);
        if ($errors) {
            $this->setErrors($errors);
        }
    }


    /**
     * Clear all params
     *
     * @return $this
     */
    public function reset()
    {
        $this->params = [
            'success' => true,
            'data'    => null,
            'errors'  => [],
            'message' => null,
            'code'    => 200,
        ];

        return $this;
    }


    /**
     * @param string    $key
     * @param mixed     $value
     */
    public function __set($key, $value)
    {
        $method = 'set' . ucfirst($key);
        if (method_exists($this, $method)) {
            return $this->{$method}($value);
        }

        throw new \Exception("Unknown property '{$key}'");
    }


    /**
     * @param  string   $key
     * @return mixed
     */
    public function __get($key)
    {
        if (!array_key_exists($key, $this->params)) {
            throw new \Exception("Invalid property '{$key}'");
        }

        return $this->params[$key];
    }


    /**
     * @param boolean   $success
     */
    public function setSuccess($success)
    {
        $this->params['success'] = (boolean) $success;
        return $this;
    }


    /**
     * @param mixed     $data
     */
    public function setData($data)
    {
        $this->params['data'] = $data;
        return $this;
    }

    /**
     * @param integer $code
     */
    public function setCode($code)
    {
        if (!is_numeric($code) || (int) $code != $code) {
            throw new \Exception('Invalid status code. Must be an integer.');
        }

        if ($code >= 400) {
            $this->setSuccess(false);
        }

        $this->params['code'] = $code;
        return $this;
    }

    /**
     * @param string|array  $error
     */
    public function setError($error)
    {
        $this->setErrors(is_array($error) ? $error : [$error]);
        return $this;
    }


    /**
     * @param array     $errors
     */
    public function setErrors(array $errors)
    {
        $this->params['errors'] = $errors;
        if ($errors) {
            $this->setSuccess(false);
        }
        return $this;
    }


    /**
     * @param string    $message
     */
    public function setMessage($message)
    {
        $this->params['message'] = $message;
        return $this;
    }


    /**
     * @return string   Json string
     */
    public function toJson()
    {
        return json_encode($this->params);
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return $this->params;
    }


    /**
     * @return string
     */
    public function send()
    {
        http_response_code($this->code);

        header('Content-Type: application/json');
        return json_encode($this->params);
    }

    /**
     * @return string   Json string
     */
    public function __toString()
    {
        return json_encode($this->params);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
