<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "polling_unit".
 *
 * @property int $uniqueid
 * @property int $polling_unit_id
 * @property int $ward_id
 * @property int $lga_id
 * @property int|null $uniquewardid
 * @property string|null $polling_unit_number
 * @property string|null $polling_unit_name
 * @property string|null $polling_unit_description
 * @property string|null $lat
 * @property string|null $long
 * @property string|null $entered_by_user
 * @property string|null $date_entered
 * @property string|null $user_ip_address
 */
class PollingUnit extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'polling_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uniquewardid', 'polling_unit_number', 'polling_unit_name', 'polling_unit_description', 'lat', 'long', 'entered_by_user', 'date_entered', 'user_ip_address'], 'default', 'value' => null],
            [['polling_unit_id', 'ward_id', 'lga_id'], 'required'],
            [['polling_unit_id', 'ward_id', 'lga_id', 'uniquewardid'], 'integer'],
            [['polling_unit_description'], 'string'],
            [['date_entered'], 'safe'],
            [['polling_unit_number', 'polling_unit_name', 'entered_by_user', 'user_ip_address'], 'string', 'max' => 50],
            [['lat', 'long'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uniqueid' => 'Uniqueid',
            'polling_unit_id' => 'Polling Unit ID',
            'ward_id' => 'Ward ID',
            'lga_id' => 'Lga ID',
            'uniquewardid' => 'Uniquewardid',
            'polling_unit_number' => 'Polling Unit Number',
            'polling_unit_name' => 'Polling Unit Name',
            'polling_unit_description' => 'Polling Unit Description',
            'lat' => 'Lat',
            'long' => 'Long',
            'entered_by_user' => 'Entered By User',
            'date_entered' => 'Date Entered',
            'user_ip_address' => 'User Ip Address',
        ];
    }

}
