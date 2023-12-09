<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: content-type');
header('Content-Type: application/json; charset=utf-8');

require_once './mysql.php';

function rs($rs) {
  echo json_encode($rs);
}

$_ = json_decode(file_get_contents('php://input'), true);

function rq($name, $inputs = null) {
  global $_;

  if (isset($_GET[$name])) {
    if ($inputs != null) {
      $rs = false;
      foreach ($inputs as $value) {
        $rs = $rs || (!isset($_[$value]) || $_[$value] == '');
      }
      return !$rs;
    } else return true;
  } else return false;
}

if (isset($_GET['download'])) {
  $filename = $_GET['download'];
  $format = (isset($_GET['HD']) ? 'wav' : 'mp3');

  $file = "./files/$filename.$format";

  $rq = $pdo->prepare('INSERT INTO downloads (music, ip) VALUES (?, ?)');
  $rq->execute([$filename, $_SERVER['REMOTE_ADDR']]);

  $size = filesize($file);
  $basename = basename($file);

  header('Cache-control: max-age=3600');
  header('Content-Type: application/octet-stream');
  header("Content-Length: $size");
  header("Content-Disposition: filename=$basename");
  flush();

  $file = fopen($file, 'r');
  print fread($file, $size);
  flush();
  fclose($file);
  exit;
}

if (rq('getMusics')) {
  $rq = $pdo->prepare('
    SELECT
      musics.file as id,
      musics.title,
      musics.tags,
      musics.date,
      (
        SELECT COUNT(likes.id)
        FROM likes
        WHERE likes.music = musics.file
      ) as likes,
      (
        SELECT COUNT(downloads.id)
        FROM downloads
        WHERE downloads.music = musics.file
      ) as downloads,
      (
        SELECT true
        FROM likes
        WHERE likes.music = musics.file AND likes.ip = ?
      ) as liked
    FROM musics
    ORDER BY date desc
  ');

  $rq->execute([$_SERVER['REMOTE_ADDR']]);
  $musics = $rq->fetchAll(PDO::FETCH_ASSOC);

  rs($musics);
}

if (rq('addLike', ['music'])) {
  $rq = $pdo->prepare('INSERT INTO likes (id, music, ip) VALUES (?, ?, ?)');
  rs([md5($_['music'] . $_SERVER['REMOTE_ADDR']), $_['music'], $_SERVER['REMOTE_ADDR']]); 

  $rq->execute([md5($_['music'] . $_SERVER['REMOTE_ADDR']), $_['music'], $_SERVER['REMOTE_ADDR']]);
}

if (rq('check')) {
  $rq = $pdo->prepare('SELECT file FROM musics');
  $rq->execute();
  $dbMusics = $rq->fetchAll(PDO::FETCH_ASSOC);

  $files = scandir('./files');

  if (!$files) {
    echo 'Error: ./files not found';
    exit;
  }

  $files = array_slice($files, 2);

  $missingMP3 = 0;
  $missingWAV = 0;

  foreach ($dbMusics as $music) {
    if (!in_array($music['file'] . '.mp3', $files)) {
      echo 'Error: ' . $music['file'] . '.mp3' . ' not found in ./files' . "\n";
      $missingMP3 += 1;
    }

    if (!in_array($music['file'] . '.wav', $files)) {
      echo 'Warning: ' . $music['file'] . '.wav' . ' not found in ./files' . "\n";
      $missingWAV += 1;
    }
  }

  $wrongExt = 0;
  $excessMP3 = 0;
  $excessWAV = 0;

  foreach ($files as $file) {
    $info = pathinfo($file);
    $name = $info['filename'];
    $ext = $info['extension'];

    if ($ext != 'mp3' && $ext != 'wav') {
      echo "Warning: $file is not a .mp3 or a .wav file, it should be removed\n";
      $wrongExt += 1;
      continue;
    }

    if ($ext == 'mp3' && !in_array($name, array_column($dbMusics, 'file'))) {
      echo "Warning: $file is an excess .mp3 file, it should be removed\n";
      $excessMP3 += 1;
      continue;
    }

    if ($ext == 'wav' && !in_array($name, array_column($dbMusics, 'file'))) {
      echo "Warning: $file is an excess .wav file, it should be removed\n";
      $excessWAV += 1;
      continue;
    }
  }

  echo "\nChecked " . count($dbMusics) . " musics:\n";
  echo "  - $missingMP3 missing .mp3 file(s)\n";
  echo "  - $missingWAV missing .wav file(s)\n";
  echo "  - $wrongExt file(s) with a wrong extension\n";
  echo "  - $excessMP3 excess .mp3 file(s)\n";
  echo "  - $excessWAV excess .wav file(s)\n";

  if ($missingMP3 + $missingWAV + $wrongExt + $excessMP3 + $excessWAV == 0) {
    echo "\nEverything is fine!\n";
  }
}
?>
