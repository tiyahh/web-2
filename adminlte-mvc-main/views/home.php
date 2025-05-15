<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "dbkegiatan_dosen");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data
if (isset($_POST['add'])) {
    $task = $conn->real_escape_string($_POST['task']);
    $deadline = $_POST['deadline'];
    $conn->query("INSERT INTO todo (task, deadline) VALUES ('$task', '$deadline')");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Update status
if (isset($_GET['toggle'])) {
    $id = (int) $_GET['toggle'];
    $status = (int) $_GET['status'];
    $conn->query("UPDATE todo SET status=$status WHERE id=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus data
if (isset($_GET['erase'])) {
    $id = (int) $_GET['erase'];
    $conn->query("DELETE FROM todo WHERE id=$id");

    // Parse current URL
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parsed_url['query'] ?? '', $query);

    // Remove the 'erase' parameter if it exists
    unset($query['erase']);

    // Build the new query string
    $new_query = http_build_query($query);

    // Create the cleaned URL
    $clean_url = $parsed_url['path'] . ($new_query ? '?' . $new_query : '');

    header("Location: " . $clean_url);
    exit();
}


// Fungsi utilitas
function getDaysInMonth($month, $year)
{
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}
function getDayName($day)
{
    $days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    return $days[$day];
}
function getMonthName($month)
{
    $months = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    return $months[$month];
}

// Ambil bulan & tahun saat ini
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

// Validasi bulan & tahun
if ($month < 1) {
    $month = 12;
    $year--;
} elseif ($month > 12) {
    $month = 1;
    $year++;
}

// Ambil task sesuai bulan & tahun
$tasks_query = $conn->query("SELECT * FROM todo WHERE MONTH(deadline) = $month AND YEAR(deadline) = $year ORDER BY deadline ASC");
$tasks = [];
while ($row = $tasks_query->fetch_assoc()) {
    $day = (int)date('j', strtotime($row['deadline']));
    if (!isset($tasks[$day])) $tasks[$day] = [];
    $tasks[$day][] = $row;
}

// Semua tugas
$todos = $conn->query("SELECT * FROM todo ORDER BY deadline ASC");

// Tugas minggu ini
$start_of_week = date('Y-m-d', strtotime('monday this week'));
$end_of_week = date('Y-m-d', strtotime('sunday this week'));
$upcoming_tasks = $conn->query("SELECT * FROM todo WHERE DATE(deadline) BETWEEN '$start_of_week' AND '$end_of_week' ORDER BY deadline ASC");
?>

<!-- HTML dimulai -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Kegiatan Dosen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <style>
        .calendar-container {
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .calendar-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3c8dbc;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-day-header,
        .calendar-day-number {
            text-align: center;
        }

        .calendar-day-header {
            font-weight: bold;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }

        .calendar-day {
            min-height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            position: relative;
        }

        .calendar-day-number {
            position: absolute;
            top: 5px;
            right: 5px;
            font-weight: bold;
            color: #666;
        }

        .current-day {
            background: #e8f4ff;
            border: 2px solid #3c8dbc;
        }

        .other-month {
            background: #f5f5f5;
            color: #aaa;
        }

        .calendar-event {
            font-size: 0.8rem;
            margin-top: 2px;
            padding: 2px 4px;
            border-radius: 3px;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .calendar-event.done {
            background: #c8e6c9;
            color: #388e3c;
            text-decoration: line-through;
        }

        .calendar-event.pending {
            background: #ffecb3;
            color: #ff8f00;
        }

        .upcoming-tasks {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .upcoming-task-item {
            padding: 10px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-left: 3px solid #3c8dbc;
        }

        .upcoming-task-item.done {
            background: #f1f8e9;
            border-left-color: #4caf50;
        }

        .task-title {
            font-weight: bold;
        }

        .task-controls {
            margin-top: 5px;
        }

        .upcoming-task-item.done .task-title {
            text-decoration: line-through;
            color: #388e3c;
        }

        .upcoming-task-item.pending {
            border-left-color: #ff9800;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <section class="content">
            <div class="container-fluid mt-4">
                <h1>Sistem Manajemen Kegiatan Dosen</h1>
                <div class="row">
                    <!-- Kalender -->
                    <div class="col-md-8">
                        <div class="calendar-container">
                            <div class="calendar-header">
                                <div class="calendar-title"><?= getMonthName($month) ?> <?= $year ?></div>
                                <div class="btn-group">
                                    <a href="?month=<?= $month - 1 ?>&year=<?= $year ?>" class="btn btn-outline-primary"><i class="fas fa-chevron-left"></i></a>
                                    <a href="?month=<?= date('m') ?>&year=<?= date('Y') ?>" class="btn btn-outline-primary">Hari Ini</a>
                                    <a href="?month=<?= $month + 1 ?>&year=<?= $year ?>" class="btn btn-outline-primary"><i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>

                            <div class="calendar-grid">
                                <?php for ($d = 0; $d < 7; $d++): ?>
                                    <div class="calendar-day-header"><?= getDayName($d) ?></div>
                                <?php endfor; ?>

                                <?php
                                $daysInMonth = getDaysInMonth($month, $year);
                                $firstDayOfMonth = date('w', strtotime("$year-$month-01"));
                                $lastDayPrevMonth = getDaysInMonth($month - 1 ?: 12, $month - 1 ? $year : $year - 1);

                                for ($i = $firstDayOfMonth - 1; $i >= 0; $i--) {
                                    echo '<div class="calendar-day other-month"><div class="calendar-day-number">' . ($lastDayPrevMonth - $i) . '</div></div>';
                                }

                                $currentDay = date('j');
                                $currentMonth = date('n');
                                $currentYear = date('Y');

                                for ($day = 1; $day <= $daysInMonth; $day++) {
                                    $isCurrent = $day == $currentDay && $month == $currentMonth && $year == $currentYear;
                                    echo '<div class="' . ($isCurrent ? 'calendar-day current-day' : 'calendar-day') . '">';
                                    echo '<div class="calendar-day-number">' . $day . '</div>';
                                    if (isset($tasks[$day])) {
                                        foreach ($tasks[$day] as $task) {
                                            $class = $task['status'] ? 'done' : 'pending';
                                            $title = htmlspecialchars($task['task']);
                                            $time = date('H:i', strtotime($task['deadline']));
                                            echo "<div class='calendar-event $class' title='$title ($time)'>" . substr($title, 0, 15) . (strlen($title) > 15 ? "..." : "") . "</div>";
                                        }
                                    }
                                    echo '</div>';
                                }

                                $filledCells = $firstDayOfMonth + $daysInMonth;
                                for ($i = 1; $i <= 42 - $filledCells; $i++) {
                                    echo '<div class="calendar-day other-month"><div class="calendar-day-number">' . $i . '</div></div>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Minggu Ini -->
                        <div class="upcoming-tasks">
                            <h4><i class="fas fa-calendar-check mr-2"></i>Tugas Minggu Ini</h4>
                            <?php if ($upcoming_tasks->num_rows): ?>
                                <?php while ($task = $upcoming_tasks->fetch_assoc()): ?>
                                    <?php
                                    $class = $task['status'] ? 'done' : 'pending';
                                    $date = date('l, d M Y', strtotime($task['deadline']));
                                    $time = date('H:i', strtotime($task['deadline']));
                                    ?>
                                    <div class="upcoming-task-item <?= $class ?>">
                                        <div class="task-title"><?= htmlspecialchars($task['task']) ?></div>
                                        <div class="task-deadline"><i class="far fa-clock mr-1"></i><?= $date ?> | <?= $time ?></div>
                                        <div class="task-controls">
                                            <a href="?toggle=<?= $task['id'] ?>&status=<?= $task['status'] ? 0 : 1 ?>" class="btn btn-sm btn-<?= $task['status'] ? 'success' : 'warning' ?>">
                                                <?= $task['status'] ? 'Selesai' : 'Belum' ?>
                                            </a>
                                            <a href="?url=home&erase=<?= $task['id'] ?>" onclick="return confirm('Hapus tugas ini?')" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="alert alert-info">Tidak ada tugas minggu ini.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- To Do List -->
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> To Do List</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" class="mb-3">
                                    <div class="form-group">
                                        <label>Tugas</label>
                                        <input type="text" name="task" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Deadline</label>
                                        <input type="datetime-local" name="deadline" class="form-control" required>
                                    </div>
                                    <button type="submit" name="add" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
                                </form>
                                <hr>
                                <ul class="todo-list">
                                    <?php while ($row = $todos->fetch_assoc()): ?>
                                        <li class="mb-2">
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" <?= $row['status'] ? 'checked' : '' ?>
                                                    onclick="location.href='?toggle=<?= $row['id'] ?>&status=<?= $row['status'] ? 0 : 1 ?>'"
                                                    id="todoCheck<?= $row['id'] ?>">
                                                <label for="todoCheck<?= $row['id'] ?>"></label>
                                            </div>
                                            <span class="<?= $row['status'] ? 'text-muted text-decoration-line-through' : '' ?>">
                                                <?= htmlspecialchars($row['task']) ?>
                                            </span>
                                            <small class="badge badge-<?= $row['status'] ? 'success' : 'warning' ?>">
                                                <i class="far fa-clock"></i> <?= date('d M Y H:i', strtotime($row['deadline'])) ?>
                                            </small>
                                            <div class="tools">
                                                <a href="?url=home&erase=<?= $row['id'] ?>" onclick="return confirm('Hapus tugas ini?')">
                                                    <i class="fas fa-trash-alt text-danger"></i>
                                                </a>
                                            </div>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <script>
        $(function() {
            $('[title]').tooltip();
        });
    </script>
</body>

</html>