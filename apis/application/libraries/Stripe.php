<?php
//error_reporting(E_ALL);

/**
 *
 */
require 'vendor/autoload.php';
class Stripe
{

    public function __construct()
    {
        $this->ci  = &get_instance();
        $this->key = $this->ci->config->item('stripe_api_key');
    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : listAllPlan
     * @ Added Date               : 14-03-2017
     * @ Added By                 : Amit pandit
     * -----------------------------------------------------------------
     * @ Description              : List all plans
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

    public function listAllPlan()
    {

        \Stripe\Stripe::setApiKey($this->key);
        $list = \Stripe\Plan::all(array("limit" => 100));
        $a    = $list->__toArray(true);
        return $a;

    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : createPlan
     * @ Added Date               : 14-03-2017
     * @ Added By                 : Amit pandit
     * -----------------------------------------------------------------
     * @ Description              : Create a recuuring plan
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

    public function createPlan($data = array())
    {

        try {
            \Stripe\Stripe::setApiKey($this->key);
            $st = \Stripe\Plan::create(array(
                "amount"         => $data['amount'],
                "interval"       => $data['interval'],
                "name"           => $data['name'],
                "currency"       => $data['currency'],
                "id"             => $data['id'],
                "interval_count" => $data['interval_count'],
            )
            );
            $response_array['response'] = $st->__toArray(true);
            return $response_array;

        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
        } catch (\Stripe\Error\InvalidRequest $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }
        //echo $st->id

    }
    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : PlanDetails
     * @ Added Date               : 14-03-2017
     * @ Added By                 : Amit pandit
     * -----------------------------------------------------------------
     * @ Description              : Get Plan details
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

    public function PlanDetails($data = array())
    {
        \Stripe\Stripe::setApiKey($this->key);

        $de             = \Stripe\Plan::retrieve($data['plan_id']);
        $response_array = $de->__toArray(true);
        return $response_array;

    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : charge
     * @ Added Date               : 14-03-2017
     * @ Added By                 : Amit pandit
     * -----------------------------------------------------------------
     * @ Description              : One time payment charge
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

    public function charge($data)
    {
        try {
            \Stripe\Stripe::setApiKey($this->key);

            $customer = \Stripe\Customer::create([
                'card'  => $data['token'],
                'email' => $data['email'],
            ]);

            $st = \Stripe\Charge::create(array(
                "amount"      => $data['amount'],
                "currency"    => $data['currency'],
                "description" => $data['description'],
                "customer"    => $customer->id,
            ));

            $response_array['response'] = $st->__toArray(true);
            //$response_array['response'] = $response['error_message']
            return $response_array;

        } catch (\Stripe\Error\Card $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Since it's a decline, \Stripe\Error\Card will be caught

        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
        } catch (\Stripe\Error\InvalidRequest $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;

            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;

            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }

    }

    /*
     * --------------------------------------------------------------------------
     * @ Function Name            : subscription
     * @ Added Date               : 14-03-2017
     * @ Added By                 : Amit pandit
     * -----------------------------------------------------------------
     * @ Description              : Subscribe a plan to customer
     * -----------------------------------------------------------------
     * @ param                    : array(param)
     * @ return                   :
     * -----------------------------------------------------------------
     *
     */

    public function subscription($data = array())
    {

        try {
            \Stripe\Stripe::setApiKey($this->key);
            $customer = \Stripe\Customer::create([
                'card'  => $data['token'],
                'email' => $data['email'],
            ]);

            $sb = \Stripe\Subscription::create(array(
                "customer" => $customer->id,
                "plan"     => $data['plan_id'],
            ));

            $response_array['response'] = $sb->__toArray(true);
            //$response_array['response'] = $response['error_message']
            return $response_array;

        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;

        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
        } catch (\Stripe\Error\InvalidRequest $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;

            // Invalid parameters were supplied to Stripe's API
        } catch (\Stripe\Error\Authentication $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
        } catch (\Stripe\Error\ApiConnection $e) {

            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Network communication with Stripe failed
        } catch (\Stripe\Error\Base $e) {
            $body                        = $e->getJsonBody();
            $err                         = $body['error'];
            $response_array['error_msg'] = $err['message'];
            return $response_array;
            // Display a very generic error to the user, and maybe send
            // yourself an email
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
        }

    }

    public function createCustomer($data = array())
    {
        \Stripe\Stripe::setApiKey($this->key);
        $customer = \Stripe\Customer::create([
            'card'        => $data['token'],
            'description' => $data['description'],
        ]);

        $sb = \Stripe\Subscription::create(array(
            "customer" => $customer->id,
            "plan"     => "basic-monthly",
        ));

        $response_array['response'] = $customer->__toArray(true);
        //$response_array['response'] = $response['error_message']
        return $response_array;

    }

}
