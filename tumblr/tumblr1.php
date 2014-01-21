<?php
include "oauth_client.php";
// Authenticate via OAuth
$client = new Tumblr\API\Client(
  'xMKbu9QRwkt2lcJaXyBIs9x8giNVSXwdflljGdRGk5PECvEwXh',
  '4O45Dj1AZtVX8Y4V3tFsXGHphLQSkgFaKuaQUIpjK0obkKAPML',
  'W1PYDPIiU4FAJcoxWKknI5RiVc5POugRdax4vQLSVmU6JyAmJM',
  '36ZWA6a3GfAwcX3FnLwIjJxMa4wbxgooIlnHlEiNDKfaLqxIFY'
);

// Make the request
$client->getUserInfo();