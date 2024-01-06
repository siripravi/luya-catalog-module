<?php
namespace siripravi\catalog;
use app\models\UserAddress;
class AfterSaveAddressHandler
{
    /**
     * Handles the after login event process to send emails
     *
     * @param FormEvent $event Event object form
     *
     * @return null
     */
    public static function handleAfterSave(\siripravi\catalog\AfterSaveAddressEvent $event)
    {
       
        $model = $event->model;
        $instance = new self();        
        $id = '';//$model->Aid;
        if (!empty($id)) {   echo "<pre>";  //print_r($address->attributes);
            echo "Address Validate...";
            die;
            $address = UserAddress::findOne($id);
            if ($address->user_profile_id == \Yii::$app->user->identity->profile->id) {
                if ($instance->load($address, $model->attributes)) {
                    if ($address->validate()) {
                        $address->save();
                      //  return $this->redirect(Url::toRoute('/user/settings/addresses'));
                    } else throw new \Exception();
                }
             /*   return $this->render('save-address', [
                    'address' => $address
                ]);*/
            } //else throw new \ForbiddenHttpException();
        } else {
            $address = new UserAddress();
            if ($instance->load($address, $model->attributes)) {
                $address->user_profile_id = \Yii::$app->user->identity->profile->id;
               /* */
                if ($address->validate()) {
                   
                    $address->save();
                  //  return $this->redirect('addresses');
                }else{
                    echo "<pre>";  print_r($address->errors);
                echo "Address Validate...";
                die;
                }
            }
           /* return $this->render('save-address', [
                'address' => $address
            ]);*/
        }
        return true;
    }

    public function load(&$model, $data){
      //  $model->id = $data['Aid'];
        $model->contact_person = $data['Name'];
        $model->contact_mobile1 = $data['Mobile1'];
        $model->contact_mobile2 = $data['Mobile2'];
        $model->house = $data['Address1'];
        $model->house = $data['Address1'];
        $model->apartment = $data['Address2'];
        $model->zipcode = $data['Pincode'];
        $model->country = 'India';
        $model->city = 'Hyderabad';
        $model->region = 'Telangana';
        $model->postoffice = '';
       return true;
    }
}