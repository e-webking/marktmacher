<?php
namespace ARM\Armpayments\Libraries\Stripe;

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('armpayments') ."Classes/Libraries/Stripe/Autoloader.php");
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur R. Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 * @package TYPO3
 * @subpackage armpayments
 * @author Anisur R. Mullick <anisur@armtechnologies.com>
 * @version 1.1.0
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
/*
// Stripe singleton
require(dirname(__FILE__) . '/lib/Stripe.php');

// Utilities
require(dirname(__FILE__) . '/lib/Util/AutoPagingIterator.php');
require(dirname(__FILE__) . '/lib/Util/CaseInsensitiveArray.php');
require(dirname(__FILE__) . '/lib/Util/LoggerInterface.php');
require(dirname(__FILE__) . '/lib/Util/DefaultLogger.php');
require(dirname(__FILE__) . '/lib/Util/RandomGenerator.php');
require(dirname(__FILE__) . '/lib/Util/RequestOptions.php');
require(dirname(__FILE__) . '/lib/Util/Set.php');
require(dirname(__FILE__) . '/lib/Util/Util.php');

// HttpClient
require(dirname(__FILE__) . '/lib/HttpClient/ClientInterface.php');
require(dirname(__FILE__) . '/lib/HttpClient/CurlClient.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/Card.php');
require(dirname(__FILE__) . '/lib/Error/Idempotency.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/Permission.php');
require(dirname(__FILE__) . '/lib/Error/RateLimit.php');
require(dirname(__FILE__) . '/lib/Error/SignatureVerification.php');

// OAuth errors
require(dirname(__FILE__) . '/lib/Error/OAuth/OAuthBase.php');
require(dirname(__FILE__) . '/lib/Error/OAuth/InvalidClient.php');
require(dirname(__FILE__) . '/lib/Error/OAuth/InvalidGrant.php');
require(dirname(__FILE__) . '/lib/Error/OAuth/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/OAuth/InvalidScope.php');
require(dirname(__FILE__) . '/lib/Error/OAuth/UnsupportedGrantType.php');
require(dirname(__FILE__) . '/lib/Error/OAuth/UnsupportedResponseType.php');

// API operations
require(dirname(__FILE__) . '/lib/ApiOperations/All.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Create.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Delete.php');
require(dirname(__FILE__) . '/lib/ApiOperations/NestedResource.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Request.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Retrieve.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Update.php');

// Plumbing
require(dirname(__FILE__) . '/lib/ApiResponse.php');
require(dirname(__FILE__) . '/lib/RequestTelemetry.php');
require(dirname(__FILE__) . '/lib/StripeObject.php');
require(dirname(__FILE__) . '/lib/ApiRequestor.php');
require(dirname(__FILE__) . '/lib/ApiResource.php');
require(dirname(__FILE__) . '/lib/SingletonApiResource.php');

// Stripe API Resources
require(dirname(__FILE__) . '/lib/Account.php');
require(dirname(__FILE__) . '/lib/AccountLink.php');
require(dirname(__FILE__) . '/lib/AlipayAccount.php');
require(dirname(__FILE__) . '/lib/ApplePayDomain.php');
require(dirname(__FILE__) . '/lib/ApplicationFee.php');
require(dirname(__FILE__) . '/lib/ApplicationFeeRefund.php');
require(dirname(__FILE__) . '/lib/Balance.php');
require(dirname(__FILE__) . '/lib/BalanceTransaction.php');
require(dirname(__FILE__) . '/lib/BankAccount.php');
require(dirname(__FILE__) . '/lib/BitcoinReceiver.php');
require(dirname(__FILE__) . '/lib/BitcoinTransaction.php');
require(dirname(__FILE__) . '/lib/Card.php');
require(dirname(__FILE__) . '/lib/Charge.php');
require(dirname(__FILE__) . '/lib/Checkout/Session.php');
require(dirname(__FILE__) . '/lib/Collection.php');
require(dirname(__FILE__) . '/lib/CountrySpec.php');
require(dirname(__FILE__) . '/lib/Coupon.php');
require(dirname(__FILE__) . '/lib/Customer.php');
require(dirname(__FILE__) . '/lib/Discount.php');
require(dirname(__FILE__) . '/lib/Dispute.php');
require(dirname(__FILE__) . '/lib/EphemeralKey.php');
require(dirname(__FILE__) . '/lib/Event.php');
require(dirname(__FILE__) . '/lib/ExchangeRate.php');
require(dirname(__FILE__) . '/lib/File.php');
require(dirname(__FILE__) . '/lib/FileLink.php');
require(dirname(__FILE__) . '/lib/FileUpload.php');
require(dirname(__FILE__) . '/lib/Invoice.php');
require(dirname(__FILE__) . '/lib/InvoiceItem.php');
require(dirname(__FILE__) . '/lib/InvoiceLineItem.php');
require(dirname(__FILE__) . '/lib/IssuerFraudRecord.php');
require(dirname(__FILE__) . '/lib/Issuing/Authorization.php');
require(dirname(__FILE__) . '/lib/Issuing/Card.php');
require(dirname(__FILE__) . '/lib/Issuing/CardDetails.php');
require(dirname(__FILE__) . '/lib/Issuing/Cardholder.php');
require(dirname(__FILE__) . '/lib/Issuing/Dispute.php');
require(dirname(__FILE__) . '/lib/Issuing/Transaction.php');
require(dirname(__FILE__) . '/lib/LoginLink.php');
require(dirname(__FILE__) . '/lib/Order.php');
require(dirname(__FILE__) . '/lib/OrderItem.php');
require(dirname(__FILE__) . '/lib/OrderReturn.php');
require(dirname(__FILE__) . '/lib/PaymentIntent.php');
require(dirname(__FILE__) . '/lib/Payout.php');
require(dirname(__FILE__) . '/lib/Person.php');
require(dirname(__FILE__) . '/lib/Plan.php');
require(dirname(__FILE__) . '/lib/Product.php');
require(dirname(__FILE__) . '/lib/Radar/ValueList.php');
require(dirname(__FILE__) . '/lib/Radar/ValueListItem.php');
require(dirname(__FILE__) . '/lib/Recipient.php');
require(dirname(__FILE__) . '/lib/RecipientTransfer.php');
require(dirname(__FILE__) . '/lib/Refund.php');
require(dirname(__FILE__) . '/lib/Reporting/ReportRun.php');
require(dirname(__FILE__) . '/lib/Reporting/ReportType.php');
require(dirname(__FILE__) . '/lib/Review.php');
require(dirname(__FILE__) . '/lib/SKU.php');
require(dirname(__FILE__) . '/lib/Sigma/ScheduledQueryRun.php');
require(dirname(__FILE__) . '/lib/Source.php');
require(dirname(__FILE__) . '/lib/SourceTransaction.php');
require(dirname(__FILE__) . '/lib/Subscription.php');
require(dirname(__FILE__) . '/lib/SubscriptionItem.php');
require(dirname(__FILE__) . '/lib/SubscriptionSchedule.php');
require(dirname(__FILE__) . '/lib/SubscriptionScheduleRevision.php');
require(dirname(__FILE__) . '/lib/Terminal/ConnectionToken.php');
require(dirname(__FILE__) . '/lib/Terminal/Location.php');
require(dirname(__FILE__) . '/lib/Terminal/Reader.php');
require(dirname(__FILE__) . '/lib/ThreeDSecure.php');
require(dirname(__FILE__) . '/lib/Token.php');
require(dirname(__FILE__) . '/lib/Topup.php');
require(dirname(__FILE__) . '/lib/Transfer.php');
require(dirname(__FILE__) . '/lib/TransferReversal.php');
require(dirname(__FILE__) . '/lib/UsageRecord.php');
require(dirname(__FILE__) . '/lib/UsageRecordSummary.php');

// OAuth
require(dirname(__FILE__) . '/lib/OAuth.php');

// Webhooks
require(dirname(__FILE__) . '/lib/Webhook.php');
require(dirname(__FILE__) . '/lib/WebhookEndpoint.php');
require(dirname(__FILE__) . '/lib/WebhookSignature.php');
*/
class T3Stripe {
    
    /**
     *
     * @var string
     */
    protected $apiKey;
    
    /**
     *
     * @var string
     */
    protected $publishKey;


    /**
     *
     * @var \Stripe\Token
     */
    protected $token;
    
    /**
     * 
     * @param string $apiKey
     */
    public function __construct($apiKey=NULL, $pubKey) {
        $this->apiKey = $apiKey;
        $this->publishKey = $pubKey;
    }
    
    /**
     * 
     * @param string $apiKey
     */
    public function setKey($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getKey() {
        return $this->apiKey;
    }
    
    /**
     * 
     * @param string $apiKey
     */
    public function setPubKey($apiKey) {
        $this->publishKey = $apiKey;
    }
    
    
    /**
     * 
     * @return string
     */
    public function getPubKey() {
        return $this->publishKey;
    }
    
    /**
     * Initiate
     */
    public function init() {
        \Stripe\Stripe::setApiKey($this->apiKey);
    }
    
    
    /**
     * 
     * @param string $email
     * @param sring $token
     * @return \Stripe\Customer
     */
    public function createCustomer($email, $token) {
        return \Stripe\Customer::create([
                'email' => $email,
                'source'  => $token,
            ]);
    }
    
    /**
     * 
     * @param \Stripe\Customer $customer
     * @param int $amount
     * @param string $currency
     */
    public function charge(\Stripe\Customer $customer, $amount, $currency='usd') {
        $charge = \Stripe\Charge::create([
            'customer' => $customer->id,
            'amount'   => $amount,
            'currency' => $currency,
        ]);
        
        return $charge;
    }
    
    /**
     * 
     * @param string $cardnumber
     * @param string $expmnth
     * @param int $expyr
     * @param int $cvv
     * @return \Stripe\Token
     */
    public function createToken($cardnumber, $expmnth, $expyr, $cvv) {
        \Stripe\Stripe::setApiKey($this->apiKey);

        $this->token = \Stripe\Token::create([
          "card" => [
            "number" => $cardnumber,
            "exp_month" => $expmnth,
            "exp_year" => $expyr,
            "cvc" => $cvv
          ]
        ]);
        
        return $this->token;
    }
    
    /**
     * 
     * @return \Stripe\Token
     */
    public function getToken() {
        return $this->token;
    }
}