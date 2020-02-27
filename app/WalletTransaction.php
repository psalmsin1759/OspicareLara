<?php
/**
 * Created by PhpStorm.
 * User: Tivas-Technologies
 * Date: 5/22/2018
 * Time: 8:57 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends  Model
{

    protected $primaryKey = "id";

    protected $table = "wallet_transaction";

    protected $fillable = ["amount", "source", "expiry", "cvv", "card_type", "response_code", "response_message", "transaction_reference", "payment_gateway", "card_number", "hospital_id", "hospital_admin_id", "user_id", "created_at"];

}