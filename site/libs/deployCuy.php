<?php

// Forked from https://gist.github.com/1809044 and https://gist.github.com/nichtich/5290675#file-deploy-php

$TITLE   = 'Git Deployment Cuy';
$VERSION = '0.1';
echo <<<EOT
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>$TITLE</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
  ...
 (o-o)    $TITLE
_/\\"/\_   v$VERSION
( =^= ) 
 ^---^
EOT;

// Check whether client is allowed to trigger an update
$allowed_ips = array_filter(explode(',', getenv('DEPLOY_WEBHOOK_IPS')));

// Get request IP
$headers = apache_request_headers();
if (@$headers["X-Forwarded-For"]) {
    $ips = explode(",",$headers["X-Forwarded-For"]);
    $ip  = $ips[0];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}

$allowed = false;
if (count($allowed_ips) > 0) {
    foreach ($allowed_ips as $allow) {
        if (stripos($ip, $allow) !== false) {
            $allowed = true;
            break;
        }
    }
} else {
    // No whitelist IPs defined, allow all
    $allowed = true;
}

if (!$allowed) {
    header('HTTP/1.1 403 Forbidden');
    echo "<span style=\"color: #ff0000\">    Sorry, no <a href='https://de.wikipedia.org/wiki/Cuy' style=\"color: #ff0000\">Cuy</a> for you.</span>\n";
    echo "</pre>\n</body>\n</html>";
    exit;
}
flush();

// Actually run the update
$commands = array(
    # 'echo $PWD',
    # 'whoami',
    'git pull',
    'git status',
    'git submodule sync',
    'git submodule update',
    'git submodule status',
    # 'test -e /usr/share/update-notifier/notify-reboot-required && echo "system restart required"',
);

echo('<br><br>');
foreach($commands as $cmd){
    
    $tmp = shell_exec("$cmd 2>&1");          // Run
    echo(htmlentities(trim($tmp)) . "\n");   // Print output
}

echo <<<EOT
    </pre>
    </body>
    </html>
EOT;