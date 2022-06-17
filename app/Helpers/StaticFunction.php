<?php

namespace App\Helpers;

use Config;
use Illuminate\Support\Str;

class StaticFunction
{
    public static function states()
    {
        $states = array(
            '0' => 'NV',
            '1' => 'CA',
            '2' => 'AZ',
            '3' => 'NM',
            '4' => 'WA',
            '5' => 'UT' 
        );
        return $states;
    }

    public static function cities()
    {
        $cities = array(
            '0' => 'Las Vegas',
            '1' => 'Henderson',
            '2' => 'North Las Ve',
            '3' => 'Boulder City',
            '4' => 'Pahrump'
        );
        return $cities;
    }

    public static function pet_types()
    {
        $pet_types = array(
            '0' => 'Beared Dragon',
            '1' => 'Bird',
            '2' => 'Cat',
            '3' => 'Chameleon',
            '4' => 'Chinchilla',
            '5' => 'Dog',
            '6' => 'Ferret',
            '7' => 'Gerbel',
            '8' => 'Goat',
            '9' => 'Guinea Pig',
            '10' => 'Hamster',
            '11' => 'Hedgehog',
            '12' => 'Iguana',
            '13' => 'Lion',
            '14' => 'Monkey',
            '15' => 'Pig',
            '16' => 'Rabbit',
            '17' => 'Rat',
            '18' => 'Reptile',
            '19' => 'Snake',
            '20' => 'Tortoise',
            '21' => 'Turtle',
            '22' => 'Other'
        );
        return $pet_types;
    }

    public static function processing_status()
    {
        $processing_status = array(
            '0' => 'Picked Up from Hospital',
            '1' => 'Picked up / Delivered',
            '2' => 'Arrived at Compassionate Pet',
            '3' => 'Cremated',
            '4' => 'Awaiting Pickup',
            '5' => 'Processing Completed',
            '6' => 'Received / Hold'
        );
        return $processing_status;
    }

    public static function customer_status()
    {
        $customer_status = array(
            '0' => 'Picked Up From Hospital',
            '1' => 'Picked Up/ Delivered'
        );
        return $customer_status;
    }

    public static function gender()
    {
        $gender = array(
            '0' => 'Male',
            '1' => 'Female'
        );
        return $gender;
    }

    public static function cremation_type()
    {
        $cremation_type = array(
            '0' => 'Individual Cremation',
            '1' => 'Viewing - Private',
            '2' => 'No Return',
            '3' => 'Other - Specify in Additional Instruction'
        );
        return $cremation_type;
    }

    public static function frame_color_type()
    {
        $frame_color_type = array(
            '0' => 'Black',
            '1' => 'Silver',
            '2' => 'Copper'
        );
        return $frame_color_type;
    }

    public static function processing_checklist()
    {
        $processing_checklist = array(
            '0' => 'Tag Assigned',
            '1' => 'Hair Sample',
            '2' => 'Paw Prints',
            '3' => 'Extra Hair',
            '4' => 'Ink Print',
            '5' => 'Extra Frame',
            '6' => 'Other (See Special Instructions)'
        );
        return $processing_checklist;
    }

    public static function urn_details()
    {
        $urn_details = array(
            '0' => 'Black',
            '1' => 'White',
            '2' => 'Black Rose',
            '3' => 'Blue Bell',
            '4' => 'None',
            '5' => 'Open'
        );
        return $urn_details;
    }

    public static function pet_additional_items()
    {
        $pet_additional_items = array(
            '0' => 'Engraved Plaque',
            '1' => 'Extra Hair (N/C)',
            '2' => 'Ink Print ($15)',
            '3' => 'Ribbon 1 ($5)',
            '4' => 'Ribbon 2 ($5)',
            '5' => '3D Paw Print ($10)',
            '6' => 'Regular Feather ($100)',
            '7' => 'Full Feather ($100)',
            '8' => 'Paw Prints',
            '9' => 'Extra Frame',
            '10' => 'Extra PHF ($25)',
            '11' => 'Rainbow Orb',
            '12' => 'Rainbow Heart',
            '13' => 'Thumbies Pendant',
            '14' => 'Glass Pendant',
            '15' => 'Other (see special instructions)'
        );
        return $pet_additional_items;
    }

    public static function petProcessingStatus()
    {
        $pet_processing_status = array(
            '0' => 'Not Completed',
            '1' => 'Completed'
        );
        return $pet_processing_status;
    }

    public static function payment_status()
    {
        $payment_status = array(
            '0' => 'Not Paid',
            '1' => 'Visa',
            '2' => 'Mastercard',
            '3' => 'Discover',
            '4' => 'Amex/Other',
            '5' => 'Cash',
            '6' => 'Cash/Card',
            '7' => 'Balance Due',
            '8' => 'Check',
            '9' => 'Pay at Pickup'
        );
        return $payment_status;
    }
}
