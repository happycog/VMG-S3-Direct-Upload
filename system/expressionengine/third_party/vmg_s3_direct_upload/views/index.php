<!-- Track the progress-->
<form action="process-form-data.php" method="POST">
    <input type="hidden" name="document_original_name" />
    <div class="progress">
        <div class="bar"></div>
    </div>
    <div class="js-message"></div>

</form>

<form action="//<?php echo $bucket_name; ?>.s3.amazonaws.com" method="POST" enctype="multipart/form-data" class="direct-upload">
    <input type="hidden" name="key" class="js-file-name" value="${filename}">
    <input type="hidden" name="AWSAccessKeyId" value="<?php echo $access_key; ?>">
    <input type="hidden" name="acl" value="<?php echo $acl; ?>">
    <input type="hidden" name="success_action_status" value="201">
    <input type="hidden" name="x-amz-storage-class" value="<?php echo $storage_class; ?>">
    <input type="hidden" name="policy" value="<?php echo $policy; ?>">
    <input type="hidden" name="signature" value="<?php echo $signature; ?>">

      <!-- Set the upload to multiple -->
    <input type="file" name="file" multiple="true" />
</form>
