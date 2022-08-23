<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductInstallationReport extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'customer_product_installation_report';

    protected $fillable = [
        // 'id',
        'uuid',
        'customer_product_id',
        'service',
        'circuit_id',
        'add_on',
        'onu_ont_type',
        'ip_gateway',
        'power_on_odp',
        'power_on_onu',
        'server',
        'speed_upload',
        'speed_download',
        'signature_technical',
        'signature_customer',
        'distribution_olt',
        'distribution_odp',

        'cable_type',
        'cable_distance',
        'roset_soc',
        'power_optic_odp',
        'power_optic_roset_onu',
        'onu_index',
        'ip_management',
        'user_login',
        'ssid',
        'wpa',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'customer_product_id' => 'integer',
        'service' => 'string',
        'circuit_id' => 'string',
        'add_on' => 'string',
        'onu_ont_type' => 'string',
        'ip_gateway' => 'string',
        'power_on_odp' => 'string',
        'power_on_onu' => 'string',
        'server' => 'string',
        'speed_upload' => 'string',
        'speed_download' => 'string',
        'signature_technical' => 'string',
        'signature_customer' => 'string',
        'distribution_olt' => 'string',
        'distribution_odp' => 'string',

        'cable_type' => 'string',
        'cable_distance' => 'string',
        'roset_soc' => 'string',
        'power_optic_odp' => 'string',
        'power_optic_roset_onu' => 'string',
        'onu_index' => 'string',
        'ip_management' => 'string',
        'user_login' => 'string',
        'ssid' => 'string',
        'wpa' => 'string',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }
}
