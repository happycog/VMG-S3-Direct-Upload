VMG S3 Direct Uplaod
=====
![Screenshot of VMG S3 Direct Upload](http://i.imgur.com/jg38NFz.png)

An Amazon S3 direct upload tool that utilizes [jQuery file upload](https://github.com/blueimp/jQuery-File-Upload) and CORS and supports batch uploading directly to S3 thereby bypassing any memory, upload, and other server-side limits.

This add on comes in the form of a field type and an EE control panel interface.

One main use of this is to upload large files to S3 when otherwise you would run into memory, upload, and other server-side limits.

**Warning:** If you are attempting to upload many large files to S3 at once, you might run into an issue where ExpressionEngine will log you out which will interrupt a S3 upload.

Installation
------

* Upload ee2/third_party/vmg_s3_direct_upload to system/expressionengine/third_party
* Upload themes/third_party/vmg_s3_direct_upload to themes/third_party
* Install the fieldtype by going to Add-Ons → Fieldtypes
* Ensure that both the Fieldtype and Module are installed

Usage
-------
* In order to get VMG S3 Direct Upload to work you have to enable CORS on your S3 bucket. Aws documentation on that can be found here: http://docs.aws.amazon.com/AmazonS3/latest/dev/cors.html#how-do-i-enable-cors
* Your CORS settings should look something like this: (note the AllowedOrigin is just a placeholder and should be changed to reflect your own website or IP address)
```xml
<CORSConfiguration>
    <CORSRule>
        <AllowedOrigin>http://0.0.0.0:3000</AllowedOrigin>
        <AllowedMethod>GET</AllowedMethod>
        <AllowedMethod>POST</AllowedMethod>
        <AllowedMethod>PUT</AllowedMethod>
        <MaxAgeSeconds>3000</MaxAgeSeconds>
        <AllowedHeader>*</AllowedHeader>
    </CORSRule>
</CORSConfiguration>
```

* VMG S3 Direct Upload accepts a number of parameters which can be defined in the system/expressionengine/config/config.php file.
* Bucket name, access key and access key secret are required items, acl and storage class are not
* If not defined acl defaults to public-read and storage class defaults to "STANDARD"
* Amazon documentation on ACL: http://docs.aws.amazon.com/AmazonS3/latest/dev/acl-overview.html
* Amazon documentation on Storage Class: http://docs.aws.amazon.com/AmazonS3/latest/dev/ChgStoClsOfObj.html

* Example config file
```
//VMG S3 Direct Upload Settings
$config['vmg_s3_bucket_name']       = "super-cool-bucket";
$config['vmg_s3_access_key_id']     = "S3AccessKeyId";
$config['vmg_s3_access_key_secret'] = "S3AccessSecretHash";
//not required config items
$config['vmg_s3_acl']                  = "private";
$config['vmg_s3_storage_class']        = "STANDARD";
```

Compatibility
---------

We've tested this with different ExpressionEngine Versions 2.5.5 and above and haven't found any issues, but let us know if you find anything it doesn't work with. It'd be helpful to supply relevant version numbers.

VMG S3 Direct Upload requires ExpressionEngine 2.5.0+ and PHP 5.3+.

Warranty/License
--------
There's no warranty of any kind. If you find a bug, please report it or submit a pull request with a fix. It's provided completely as-is; if something breaks, you lose data, or something else bad happens, the author(s) and owner(s) of this add-on are in no way responsible.

This add-on is owned by [Vector Media Group, Inc](http://www.vectormediagroup.com). You can modify it and use it for your own personal or commercial projects, but you can't redistribute it.
