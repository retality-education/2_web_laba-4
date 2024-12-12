
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RETALITY</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="darktheme.css">
    <link rel="stylesheet" href="sort.css">
</head>

<body>
    <!-- Switcher of Theme -->
    <input type="checkbox" id="darktheme-toggle">
    <label for="darktheme-toggle"></label>
    <div class="background"></div> 

    <span id="sort-title">Сортировка: </span>
    <input type="radio" id="sort-priority" name="sort" checked>
    <label for="sort-priority">По приоритету</label>
    <input type="radio" id="sort-type" name="sort">
    <label for="sort-type">По типу</label>

    <input type="radio" id="selected" name="status" checked>
    <input type="radio" id="in-progress" name="status">
    <input type="radio" id="testing" name="status">
    <input type="radio" id="done" name="status">
    <div class="view-selector">
        <label class="status-label" for="selected">Selected</label>
        <label class="status-label" for="in-progress">In Progress</label>
        <label class="status-label" for="testing">Testing</label>
        <label class="status-label" for="done">Done</label>
    </div>
    
    <div class="tasks-container">
        <style>
            .task_type-issue .number::after {
                content: " issue";
            }

            .task_type-report .number::after {
                content: " report";
            }

            .task_type-bug .number::after {
                content: " bug";
            }

            .task_type-feature .number::after {
                content: " feature";
            }
        </style>
        <?php
            require_once('DBConnect.php');
            $db_handle = new DBConnect();
            $tasks = $db_handle->
            runQuery("SELECT 
            USERS.FULL_NAME as username,
            USERS.IMG_SRC as user_image,
            
            TYPES.TYPE as task_type,
            TYPES.TYPE_CSS_ID as task_type_tagname,
            
            PRIORITIES.PRIORITY as task_priority,
            PRIORITIES.PRIORITY_CSS_ID as task_priority_tagname,

            STATUSES.ID as status_id,
            STATUSES.STATUS as task_status,
            STATUSES.STATUS_CSS_ID as task_status_tagname,
 
            TASKS.ID as task_id,
            TASKS.THEME as task_theme,
            TASKS.DESCRIPTION as task_description from TASKS

                LEFT JOIN USERS ON TASKS.USER_ID = USERS.ID
                LEFT JOIN STATUSES ON TASKS.STATUS_ID = STATUSES.ID
                LEFT JOIN TYPES ON TASKS.TYPE_ID = TYPES.ID
                LEFT JOIN PRIORITIES ON TASKS.PRIORITY_ID = PRIORITIES.ID

                ORDER BY status_id ASC");
            $statuses = $db_handle->runQuery("SELECT STATUS as statusname,  STATUS_CSS_ID as task_status_tagname from STATUSES ORDER BY ID ASC");

            for ($k = 1; $k <= count($statuses); $k++) {
                        echo '<div id = "'.$statuses[$k - 1]["task_status_tagname"].'" class="status">';
                        echo '  <h2>'.$statuses[$k - 1]["statusname"].'</h2>';
                for ($i = 0; $i < count($tasks); $i++) {
                    if ($tasks[$i]["status_id"] == $k) {
                        echo '  <div class="task '.$tasks[$i]["task_priority_tagname"].' '.$tasks[$i]["task_type_tagname"].'">';
                        echo '      <div class="number">Task №'.$tasks[$i]["task_id"].'</div>';
                        echo '      <div class="task__title">'.$tasks[$i]["task_theme"].'</div>';
                        echo '      <div class="task__user">';
                        echo '          <div class="avatar"><img src="'.$tasks[$i]["user_image"].'" alt=" " title=""></div>';
                        echo '          <div class="name">'.$tasks[$i]["username"].'</div>';
                        echo '      </div>';
                        echo '      <a href="#task-'.$tasks[$i]["task_id"].'">Подробнее</a>';
                        echo '  </div>';
                    }
                }
                        echo'   <p class="no-tasks">Нет задач в этом статусе.</p>';
                        echo'</div>';
            }
            echo '<div id="close" style="display: none;"></div>';

            for ( $i = 0; $i < count($tasks); $i++) {
                echo '<div id="task-'.$tasks[$i]["task_id"].'" class="task-details">';
                echo '  <span class="close"><a href="#">✖</a></span>';
                echo '  <h3>Task #'.$tasks[$i]["task_id"].'</h3>';
                echo '  <p>Тип: '.$tasks[$i]["task_type"].'</p>';
                echo '  <p>Приоритет: '.$tasks[$i]["task_priority"].'</p>';
                echo '  <p>Тема: '.$tasks[$i]["task_theme"].'</p>';
                echo '  <p>Исполнитель: '.$tasks[$i]["username"].'</p>';
                echo '  <p><strong>Описание:</strong> '.$tasks[$i]["task_description"].'</p>';
                echo '</div>';
            }


        ?>
</body>
</html>