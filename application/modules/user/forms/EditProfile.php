<?php

/**
 * Edit user profile form
 *
 * @category Application
 * @package    Application_Modules_User
 * @subpackage Form
 * @author Vadim Leontiev <vadim.leontiev@gmail.com>
 * @see https://github.com/newage/clean-zfext
 * @since php 5.1 or higher
 */
class User_Form_EditProfile extends Core_Form
{

    /**
     * Create user registration form
     * Set attribute required to form for view required fields
     */
    public function init()
    {
        $this->setMethod('post')
             ->setName('editprofile')
             ->setDescription('Edit Profile')
             ->setAttrib('required', 'true');

        //Add first name
        $element = new Zend_Form_Element_Text('name');
        $element->setLabel('Your name');
        $element->addValidator('StringLength', true, array(2,255));
        $element->addValidator('Alnum', true, array(true));
        $element->addDecorator(new Core_Form_Decorator_TwitterInput());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(1);
        $this->addElement($element);

        //Add birthday
        $element = new Zend_Form_Element_Text('birthday');
        $element->setLabel('Date of Birth');
        $element->addDecorator(new Core_Form_Decorator_TwitterDatepicker(
            array('autoclose' => true, 'format' => 'yyyy-mm-dd')
        ));
        $element->addValidator('Date', true, array(
            'messages' => array(
                Zend_Validate_Date::INVALID_DATE => 'Not a valid date',
                Zend_Validate_Date::FALSEFORMAT => 'Not a valid date'),
            'format'=>'YYYY-MM-dd'));
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(2);
        $this->addElement($element);

        //Add location
        $element = new Zend_Form_Element_Text('location');
        $element->setLabel('Location');
        $element->addDecorator(new Core_Form_Decorator_TwitterInput());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(3);
        $this->addElement($element);

        //Upload avatar
        $element = new Zend_Form_Element_File('avatar');
        $element->setLabel('Avatar');
        $element->setDescription('Select avatar');
        $element->addValidator('Size', false, 102400);
        $element->addValidator('Extension', false, array('jpg', 'png'));
        $element->addValidator('MimeType', false, array('image/png', 'image/jpeg'));
        $element->addDecorator(new Core_Form_Decorator_TwitterAvatar());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setValueDisabled(true);
        $element->setAttrib('class', 'thumbnail');
        $element->setAttrib('width', '100');
        $element->setAttrib('height', '100');
        $element->setAttrib('default', Application_Model_Images::DEFAULT_IMAGE);
        $element->setOrder(5);
        $this->addElement($element);

        //Gender
        $element = new Zend_Form_Element_Radio('gender');
        $element->addMultiOptions(array('male'=>'Male', 'female'=>'Female'));
        $element->setLabel('Gender');
        $element->addDecorator(new Core_Form_Decorator_TwitterRadio());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(6);
        $this->addElement($element);

        //About
        $element = new Zend_Form_Element_Textarea('about');
        $element->setLabel('About');
        $element->addDecorator(new Core_Form_Decorator_TwitterTextarea());
        $element->addDecorator(new Core_Form_Decorator_TwitterErrors());
        $element->setOrder(7);
        $this->addElement($element);

        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Update');
        $element->addDecorator(new Core_Form_Decorator_TwitterButtons);
        $element->setOrder(8);
        $this->addElement($element);
    }
}
