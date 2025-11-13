<?php

function query($str, $get_res = true) {
  $db = SessionHandlerCustom::connect_db();
  $query = $db->query($str);

  if (!$get_res)
    return $query;

  $result = $query->fetch_all(MYSQLI_ASSOC);
  $query->free();

  return $result;
}

class SessionHandlerCustom implements SessionHandlerInterface {
  public static $DB = null;

  public static function connect_db(): mysqli {
    if (self::$DB === null) {
      // ⚙️ Configuration dynamique selon la machine
      $host = "127.0.0.1";
      $user = "webuser";
      $pass = "password";
      $db_name = "session_cluster";

      $port = 3308;
      $conn = @mysqli_connect($host, $user, $pass, '', $port);
      if (!$conn) {
        $port = 3308;
      }

      self::$DB = new mysqli($host, $user, $pass, $db_name, $port);

      if (self::$DB->connect_error) {
        die("❌ Database connection failed: " . self::$DB->connect_error);
      }
      echo "✅ Connected to MariaDB on port $port\n";
    }

    return self::$DB;
  }

  public function open(string $path, string $name): bool {
    return true;
  }

  public function close(): bool {
    return true;
  }

  public function destroy(string $id): bool {
    return query("DELETE FROM sessions WHERE session_id = '$id'", false);
  }

  public function read(string $id): string|false {
    $result = query("SELECT * FROM sessions WHERE session_id = '$id'");
    if (count($result) <= 0)
      return "";

    return $result[0]['session_value'];
  }

  public function write(string $id, string $data): bool {
    $result = query("SELECT * FROM sessions WHERE session_id = '$id'");
    if (count($result) <= 0)
      return query("INSERT INTO sessions (session_id, session_value) VALUES ('$id', '$data')", false);

    return query("UPDATE sessions SET session_value='$data', modified_at=NOW() WHERE session_id='$id'", false);
  }

  public function gc(int $max_lifetime): int|false {
    return 1;
  }
}

session_set_save_handler(new SessionHandlerCustom());
session_start();

$_SESSION['time'] = date('H:i:s');

echo "<pre>";
print_r($_SESSION);
echo "</pre>";
