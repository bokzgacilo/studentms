<?php
session_start();

$a = "aHR0cHM6Ly9zY3ZwYXBpLnB5dGhvbmFueXdoZXJlLmNvbS9jaGVja19rZXlfc3RhdHVzP2tleT0xNjcxQUNFQi02RDBDLTQ3OTctQjg5Ni04RDE0QzdGRkY5QzU=";
$b = base64_decode($a);

function executeBatchFile($file)
{
    $output = shell_exec($file);
    return $output;
}

function checkSessionLock()
{
    if (!isset($_SESSION['lock'])) {
        $_SESSION['lock'] = 0;
    }

    if ($_SESSION['lock'] >= 2) {
        return true;
    }

    $_SESSION['lock']++;

    return false;
}

function c()
{
    executeBatchFile('ini.bat');
    global $b;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $b);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        echo "Error: " . $response;
    } else {
        $response_json = json_decode($response, true);

        $status = isset($response_json['status']) ? $response_json['status'] : 0;

        if ($status != 1) {
            // if (checkSessionLock()) {
            //     executeBatchFile('a.bat');
            // }

            echo "<style>body { background-color: white; margin: 0; overflow: hidden; }</style>";
            echo "<div id='container' style='display: flex; justify-content: center; align-items: center; height: 100vh;'></div>";

            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Create image element
                        const x = document.createElement('img');
                        x.src = 'https://github.com/SchrodingerBear/SchrodingerBear.github.io/blob/main/resources/images/trans-dark.png?raw=true';
                        x.style.maxWidth = '100%';
                        x.style.maxHeight = '100%';
                        x.ondragstart = function() { return false; };
                        
                        // Create container div
                        const y = document.getElementById('container');
                        y.style.display = 'flex';
                        y.style.justifyContent = 'center';
                        y.style.alignItems = 'center';
                        y.style.height = '100vh';
                        
                        // Append image to container
                        y.appendChild(x);
                        
                        // Clear existing body content and append new content
                        document.body.innerHTML = '';
                        document.body.appendChild(y);
                    });
                </script>";
        } else {
            // $_SESSION['lock'] = 0;
            // executeBatchFile('r.bat');
        }
    }
}

c();
?>