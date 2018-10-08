<?php namespace Cloudtux\Dns;

use Symfony\Component\Process\Process;

use Carbon\Carbon;

class Dns
{

    protected $dns;

    public function analyze($domain)
    {

        $this->dns        = new \stdClass();
        $this->dns->a     = dns_get_record($domain, DNS_A);
        $this->dns->ns    = dns_get_record($domain, DNS_NS);
        $this->dns->mx    = dns_get_record($domain, DNS_MX);
        $this->dns->txt   = dns_get_record($domain, DNS_TXT);
        $this->dns->ptr   = dns_get_record($domain, DNS_PTR);
        $this->dns->cname = dns_get_record($domain, DNS_CNAME);
        $this->dns->srv   = dns_get_record($domain, DNS_SRV);

        $this->getWhois($domain);
        $this->getRegistrar();

        return $this->dns;

    }

    private function getWhois($domain)
    {

        $process = new Process('whois ' . $domain);
        $process->run();

        $this->dns->whois = explode("\n", $this->clean($process->getOutput()));

    }

    private function getRegistrar()
    {

        $this->dns->registrar = new \stdClass();

        $whois = $this->clean($this->dns->whois);
        unset($this->dns->whois);

        $i = 0;
        foreach ($whois as $item) {

            $item = trim(strtolower($item));

            if ($item != '') {
                $this->dns->whois[] = $item;
            }

            if (preg_match('/registrar:(.*)/', $item, $result)) {

                if ($result[1] != '') {
                    $this->dns->registrar->name = trim($result[1]);
                } else {
                    $this->dns->registrar->name = trim($whois[$i + 1]);
                }

            }

            if (preg_match('/registration date: (.*)/', $item, $result)) {

                $this->dns->registrar->created = Carbon::parse(trim($result[1]));

            }

            if (preg_match('/registered on: (.*)/', $item, $result)) {

                $this->dns->registrar->created = Carbon::parse(trim($result[1]));

            }

            if (preg_match('/creation date: (.*)/', $item, $result)) {

                $this->dns->registrar->created = Carbon::parse(trim($result[1]));

            }

            if (preg_match('/renewal date:(.*)/', $item, $result)) {

                $this->dns->registrar->expires = Carbon::parse(trim($result[1]));

            }

            if (preg_match('/expiry date:(.*)/', $item, $result)) {

                $this->dns->registrar->expires = Carbon::parse(trim($result[1]));

            }

            $i++;

        }

    }

    public function clean($data)
    {

        $data = preg_replace('/\r/', '', $data);

        return $data;

    }


}