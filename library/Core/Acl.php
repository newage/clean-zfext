<?php
/**
 * Config support
 *
 * @category Core
 * @package  Core_Acl
 */

class Core_Acl extends Zend_Acl
{

    const ALLOW = 'allow';
    const DENY  = 'deny';

    /**
     * Constructor
     *
     * @param Zend_Config $config
     */
    public function  __construct(Array $config)
    {
        $this->_build($config);
    }

    /**
     * Add rules to Acl
     *
     * @param array|Zend_Config $config
     */
    protected function _build(Array $config)
    {
        if (isset($config['roles'])) {
            $this->_addRoles($config['roles']);
        }

        if (isset($config['resources'])) {
            $this->_addResources($config['resources']);
        }

        if (isset($config['mvc'])) {
            $this->_addMvc($config['mvc']);
        }

        //Allow all resource to role admin
        $this->allow('admin');

        return $this;
    }

    /**
     * Add roles
     * Enable nested roles
     *
     * @param array $roles
     */
    protected function _addRoles($roles)
    {
        foreach ($roles as $name => $parent) {
            if (!$this->hasRole($name)) {
                if (empty($parent['parent']) || $name == $parent['parent']) {
                    $parent['parent'] = null;
                }
                $this->addRole(new Zend_Acl_Role($name), $parent['parent']);
            }
        }
        return $this;
    }

    /**
     * Check resources type and add resource
     * Disable nested resource
     *
     * @param array $resources
     * @return Core_Acl
     */
    protected function _addResources(array $resources)
    {
        foreach ($resources as $resource => $rule) {
            $this->_addResource($resource);
            $this->_addRule($rule, $resource);
        }

        return $this;
    }

    /**
     * Add one resource
     * @param string $resource
     * @return Core_Acl
     */
    protected function _addResource($resource)
    {
        if (!$this->has($resource)) {
            $this->add(new Zend_Acl_Resource($resource));
        }

        return $this;
    }

    /**
     * Add mvc routes
     *
     * @param array $mvc Mvc resources
     * @param Core_Acl $mvc
     */
    protected function _addMvc(array $mvc)
    {
        foreach ($mvc as $moduleName => $controllers) {
            foreach ($controllers as $controllerName => $rules) {
                $resource = $moduleName . '/' . $controllerName;

                $this->_addResource($resource);

                $this->_addRule($rules, $resource);
            }
        }
        return $this;
    }

    /**
     * Add one rule
     *
     * @param array $rules
     * @param string $resource
     * @param string|null $privileges
     * @return Core_Acl
     */
    protected function _addRule(array $rules, $resource, $privileges = null)
    {

        if (isset($rules[self::ALLOW])) {
            $rules[self::ALLOW] = explode(',', $rules[self::ALLOW]);
        } else {
            $rules[self::ALLOW] = array();
        }

        if (isset($rules[self::DENY])) {
            $rules[self::DENY] = explode(',', $rules[self::DENY]);
        } else {
            $rules[self::DENY] = array();
        }

        foreach ($rules[self::ALLOW] as $role) {
            $this->allow($role, $resource, $privileges);
        }
        unset($rules[self::ALLOW]);

        foreach ($rules[self::DENY] as $role) {
            $this->deny($role, $resource, $privileges);
        }
        unset($rules[self::DENY]);

        if (count($rules) > 0) {
            foreach ($rules as $privileges => $rules) {
                $this->_addRule($rules, $resource, $privileges);
            }
        }

        return $this;
    }
}