<?php

/**
 * Mapper for profile model
 *
 * @category Application
 * @package    Application_Model
 * @subpackage Mapper
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class Application_Model_Mapper_Profile extends Core_Model_Mapper_Abstract
{

    protected $_prefixCache = 'user_profile';
    
    /**
     * Save new profile
     *
     * @param array $formValues
     * @return User_Model_Users
     */
    public function save($formValues)
    {
        $table = $this->getDbTable();
        return $table->insert($model->toArray());
    }

    /**
     * Find profile for user
     * 
     * @param int $id
     * @return Application_Model_Profile
     */
    public function find($id)
    {
        $cacheId = $this->_getCacheId($id);

        if (!($user = $this->_loadCache($cacheId))) {
            $profile = $this->getDbTable()->getById($id);

            if ($profile === null) {
                return null;
            }

            $image = $profile->findDependentRowset('Application_Model_DbTable_Image');
            $profile->setImageModel($image);
                
            $this->_saveCache($profile, $cacheId, array('users_details'));
        }

        return $profile;
    }
    
    /**
     * Get profile for logined user
     *
     * @return Application_Model_Profile
     */
    public function getCurrentProfile()
    {
        $userId = $this->_getCurrentUserId();
        $profile = $this->getDbTable()->getByUser_id($userId);
        return $profile;
    }

    /**
     * Update user data
     * @param Application_Model_UsersDetails $request
     * @return mixed
     */
    public function update(User_Model_Profile $model)
    {
        //Upload image
        $imageModel = new Application_Model_Images();
        $imageModel->setSizeWidth(Application_Model_Images::SIZE_MEDIUM_WIDTH);
        $imageModel->setSizeHeight(Application_Model_Images::SIZE_MEDIUM_HEIGHT);

        $imageMapper = new Application_Model_ImagesMapper();
        $imageModel = $imageMapper->setModel($imageModel)->resize()->upload();

        //Get user profile
        $profile = $this->getDbTable()->getById($model->get);

        if ($profile === null) {
            //Create new user profile
            $profile = $this->getDbTable()->create();
        }

        $profile->setName($model->getName());
        $profile->setBirthday($model->getBirthday());
        $profile->setLocation($model->getLocation());
        $profile->setAbout($model->getAbout());
        $profile->setGender($model->getGender());
        $profile->setImageId($imageModel->getId());

        $profile->save();

        $cacheId = md5('users_' . $profile->getUserId());
        return $this->removeCache($cacheId);
    }
}
