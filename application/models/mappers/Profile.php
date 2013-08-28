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
     * Save new user and upload avatar
     *
     * @return User_Model_Users
     */
    public function save(Core_Model_Abstract $model)
    {
        $table = $this->getDbTable();
        return $table->insert($model->toArray());
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
