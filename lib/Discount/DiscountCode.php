<?php
namespace PHPCartzy\Discount;

use PHPCartzy\Exception\SdkException;
use PHPCartzy\HttpRequest;

class DiscountCode
{


    public function __construct()
    {
    }

    /**
     * Get List Of Discount Codes
     * @return mixed
     * @throws SdkException
     */
    public function get()
    {
        try {
            $request = new HttpRequest();
            return $request->get('discount/list');
        }
        catch (SdkException $ex) {
            throw $ex;
        }
    }

}
