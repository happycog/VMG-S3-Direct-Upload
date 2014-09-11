<?php

class Vmg_s3_direct_upload_lib
{
    public function __construct()
    {
        $this->bucket_name      = ee()->config->item('vmg_s3_bucket_name');
        $this->access_secret    = ee()->config->item('vmg_s3_access_key_secret');
        $this->access_key       = ee()->config->item('vmg_s3_access_key_id');
        //config items that are not required
        $this->acl              = ee()->config->item('vmg_s3_acl') ? ee()->config->item('vmg_s3_acl') : 'public-read';
        $this->storage_class    = ee()->config->item('vmg_s3_storage_class') ? ee()->config->item('vmg_s3_storage_class') : 'STANDARD';

        //create the signature
        $this->signature = $this->policy_signature($this->policy_generator());
    }

    /**
     * Create policy to enable S3 direct upload
     * @return json base encoded object
     */
    public function policy_generator()
    {
        $now = strtotime(date("Y-m-d\TG:i:s"));
        //set the policy to expire the next day
        $expire = date("Y-m-d\TG:i:s\Z", strtotime('+1 day', $now));

        $policy ='{
                "expiration": "' . $expire . '",
                "conditions": [
                    {
                        "bucket": "' . $this->bucket_name . '"
                    },
                    {
                        "acl": "' .$this->acl.'"
                    },
                    {
                        "x-amz-storage-class": "' .$this->storage_class. '"
                    },
                    [
                        "starts-with",
                        "$key",
                        ""
                    ],
                    {
                        "success_action_status": "201"
                    }
                ]
            }';

        return base64_encode($policy);

    }

    /**
     * Calculate HMAC-SHA1 according to RFC2104
     * See http://www.faqs.org/rfcs/rfc2104.html
     */
    protected function hmacsha1($key,$data)
    {
        $blocksize=64;
        $hashfunc='sha1';
        if (strlen($key)>$blocksize)
            $key=pack('H*', $hashfunc($key));
        $key=str_pad($key,$blocksize,chr(0x00));
        $ipad=str_repeat(chr(0x36),$blocksize);
        $opad=str_repeat(chr(0x5c),$blocksize);
        $hmac = pack(
                    'H*',$hashfunc(
                        ($key^$opad).pack(
                            'H*',$hashfunc(
                                ($key^$ipad).$data

                            )
                        )
                    )
                );
        return bin2hex($hmac);
    }

    /**
     * Used to encode a field for Amazon Auth
     * (taken from the Amazon S3 PHP example library)
     */
    protected function hex2b64($str)
    {
        $raw = '';
        for ($i=0; $i < strlen($str); $i+=2)
        {
            $raw .= chr(hexdec(substr($str, $i, 2)));
        }
        return base64_encode($raw);
    }

    /**
     * Creates policy signature
     * @return string
     */
    protected function policy_signature($policy)
    {
        $signature = $this->hex2b64($this->hmacsha1($this->access_secret,$policy));

        return $signature;
    }

}
?>
