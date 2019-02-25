<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;

class Droplet extends Model
{
    protected $fillable = [
        'user_id', 'subscription_id', 'name', 'desc',
        'do_id', 'memory', 'vcpus', 'disk', 'hostname', 'domain',
        'region', 'public_ip', 'private_ip', 'backup_enabled'
    ];

    public static function provision($hostname)
    {
        //TODO raise error if hostname is blank
        //TODO Location and image id should come from some config file.
        return DigitalOcean::droplet()->create($hostname, 'sgp1', '1gb', '34216095', true);
    }

    public function getServerInstance()
    {
        return DigitalOcean::droplet()->getById($this->do_id);
    }

    public function getIp()
    {
        if (!empty($this->public_ip)) {
            return $this->public_ip;
        }

        $ip = $this->getServerInstance()->networks[0]->ipAddress;

        if (!empty($ip)) {
            $this->public_ip = $ip;
            $this->save();
        }

        return $ip;
    }

    public function getStatus()
    {
        return $this->getServerInstance()->status;
    }

    public function setDomain($domainName)
    {
        $domain = DigitalOcean::domain();

        if (!empty($this->domain)) {
            $domain->delete($this->domain);
        }

        $domain->create($domainName, $this->getIp());

        $this->domain = $domainName;

        $this->save();
    }
}
