<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Eileen">
    <meta name="keywords" content="learn,html5,css">
    <meta name="robots" content="index,follow">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/icon2.png" type="image/png" sizes="72x72">
    <title>WP-Calendar</title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/calendar.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/todayInfo.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/moddal.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/portrait.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/calendar_border.css">

    <script src="https://kit.fontawesome.com/e45ac9a14a.js" crossorigin="anonymous"></script>
    <style media="screen"></style>
    <script>
        let postIts = []; //記事陣列，用來放置月曆中的記事物件資料
    </script>

</head>

<body>
    <?php
    function db_updateTheme($newTheme)
    {
        global $wpdb;
        $table = $wpdb->prefix . "calendar_theme";
        $wpdb->update(
            $table,
            array("cur_theme" => $newTheme),
            array("id" => 1),
            array("%s"),
            array("%d")
        );
    }
    if (isset($_POST['color'])) { //透過關聯陣列$_POST['color']取得傳送過來的color資料
        db_updateTheme($_POST['color']); //呼叫db_updateTheme方法
    }

    //讀取theme裡的顏色
    function setTheme()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'calendar_theme';
        $query = $wpdb->prepare("SELECT cur_theme FROM $table where id='1'");
        $theme = $wpdb->get_var($query);
        return $theme;
    }

    //Notes - Create
    function db_insertNote($uid, $color, $text)
    { //新增記事資料函式
        global $wpdb;  //宣告WordPress的全域資料庫物件    
        $text = $wpdb->_real_escape($text);
        $wpdb->insert(
            $wpdb->prefix . "calendar_notes",
            array(
                "note_id" => $uid,
                "note_color" => $color,
                "note_text" => $text
            ),
            array(
                "%s",
                "%s",
                "%s"
            )
        );
    }
    if (isset($_POST['new_note_uid'])) { //前端傳來新增記事資料
        db_insertNote($_POST['new_note_uid'], $_POST['new_note_color'], $_POST['new_note_text']);
    }

    //Notes - Update
    function db_updateNote($uid, $text)
    { //更新記事資料函式
        global $wpdb;  //宣告WordPress的全域資料庫物件    
        $text = $wpdb->_real_escape($text);
        $wpdb->update(
            $wpdb->prefix . "calendar_notes",
            array(
                "note_text" => $text
            ),
            array("note_id" => $uid),
            array("%s"),
            array("%s")
        );
    }
    if (isset($_POST['update_note_uid'])) { //若前端有傳來更新記事資料
        db_updateNote($_POST['update_note_uid'], $_POST['update_note_text']);
    }

    //Note - Delete
    function db_deleteNote($uid)
    { //刪除記事資料函式
        global $wpdb;  //宣告WordPress的全域資料庫物件    
        $wpdb->delete(
            $wpdb->prefix . "calendar_notes",
            array("note_id" => $uid),
            array("%s")
        );
    }
    if (isset($_POST['delete_note_uid'])) { //刪除記事資料
        db_deleteNote($_POST['delete_note_uid']);
    }
    ?>

    <!-- 左欄 今日資訊 -->
    <div id="todayInfo" class="todayColor default-cursor">
        <h1 id="app-name-landscape" class="off-color text-center">This My Calendar</h1>
        <h2 id="cur-year" class="text-center">2022</h2>
        <div>
            <h2 id="cur-day" class="text-center today-heading">Thursday</h2>
            <h2 id="cur-month" class="text-center today-heading">June</h2>
            <h2 id="cur-date" class="text-center today-heading">30</h2>
        </div>
        <div>
            <button id="theme-landscape" class="button font" onclick="openFavColor();">Change Theme</button>
        </div>
    </div>
    <!-- 右欄 月曆-->
    <div id="calendar">
        <h1 id="app-name-portrait" class="text-center off-color">MyCalendar</h1>
        <table class="default-cursor">
            <thead class="todayColor">
                <tr>
                    <th colspan="7" class="border-color">
                        <h4 id="cal-year">2022</h4>
                        <div>
                            <i class="fas fa-caret-left icon" onclick="previousMonth()"></i>
                            <h3 id="cal-month">June</h3>
                            <i class="fas fa-caret-right icon" onclick="nextMonth()"></i>
                        </div>
                    </th>
                </tr>

                <tr>
                    <th class="weekday border-color">Sun</th>
                    <th class="weekday border-color">Mon</th>
                    <th class="weekday border-color">Tue</th>
                    <th class="weekday border-color">Wed</th>
                    <th class="weekday border-color">Thu</th>
                    <th class="weekday border-color">Fri</th>
                    <th class="weekday border-color">Sat</th>
                </tr>
            </thead>
            <tbody id="table-body" class="border-color">
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);" class="tooltip note">1 <img src="./images/note1.png" alt="note1"><span>這是提示～</span></td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);" id>1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);" id="today">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
                <tr>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                    <td onclick="dayClicked(this);">1</td>
                </tr>
            </tbody>
        </table>
        <button id="theme-portrait" class="button font todayColor" onclick="openFavColor();">Change Theme</button>
    </div>
    <!-- 浮水印 -->
    <div class="bgtext">
        <h3 class="background-text off-color ">2022</h3>
        <h4 class="background-text off-color">Calendar</h4>
    </div>
    <dialog id="modal">
        <div id="fav-color" hidden>
            <div class="popup">
                <h4 class="text-center">What's your favorite color?</h4>
                <div id="color-options">
                    <div class="color-option">
                        <div class="color-preview" id="Blue" style="background-color:#1B19CD;" onclick="addCheckMark('Blue');"><i class="fa-solid fa-check checkmark"></i></div>
                        <h5>Blue</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="Red" style="background-color:#FF0000;" onclick="addCheckMark('Red');"></div>
                        <h5>Red</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="LimeGreen" style="background-color:#32CD32;" onclick="addCheckMark('LimeGreen');"></div>
                        <h5>Lime<br>Green</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="Cyan" style="background-color:#00FFFF;" onclick="addCheckMark('Cyan');"></div>
                        <h5>Cyan</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="Turquoise" style="background-color:#40E0D0;" onclick="addCheckMark('Turquoise');"></div>
                        <h5>Turquoise</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="SkyBlue" style="background-color:#87CEEB;" onclick="addCheckMark('SkyBlue');"></div>
                        <h5>SkyBlue</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="LightSkyBlue" style="background-color:#87CEFA;" onclick="addCheckMark('LightSkyBlue');"></div>
                        <h5>Light<br>SkyBlue</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="DeepSkyBlue" style="background-color:#00BFFF;" onclick="addCheckMark('DeepSkyBlue');"></div>
                        <h5>Deep<br>SkyBlue</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="DodgerBlue" style="background-color:#1E90FF;" onclick="addCheckMark('DodgerBlue');"></div>
                        <h5>Dodger<br>Blue</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="Tan" style="background-color:#D2B48C;" onclick="addCheckMark('Tan');"></div>
                        <h5>Tan</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="MediumAquamarine" style="background-color:#66CDAA;" onclick="addCheckMark('MediumAquamarine');"></div>
                        <h5>Medium<br>Aquamarine</h5>
                    </div>

                    <div class="color-option">
                        <div class="color-preview" id="tomato" style="background-color:#FF6347;" onclick="addCheckMark('tomato');"></div>
                        <h5>Tomato</h5>
                    </div>

                </div>
                <button id="update-theme-button" class="button font todayColor" onclick="changeColor();">Update</button>
            </div>
        </div>
        <div id="make-note" hidden>
            <div class="popup">
                <h4>Add notes to the calendar</h4>
                <textarea name="post-it" id="edit-post-it" autofocus></textarea>
                <div>
                    <button class="button font post-it-button" id="add-post-it" onclick="submitPostIt()">Post</button>
                    <button class="button font post-it-button" id="delete-button" onclick="deleteNote()">Delete</button>
                </div>
            </div>
        </div>
    </dialog>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/updateDates.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/renderCalendar.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/changeThemes.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/postit.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/ajax.js"></script>

    <?php
    function getNoteData()
    {
        global $wpdb;  //宣告WordPress的全域資料庫物件    
        // $query = "SELECT * FROM notes";
        $data = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "calendar_notes");

        $id = 0;
        $color = 1;
        $text = "";
        foreach ($data as $row) {
            $id = $row->note_id;
            $color = $row->note_color;
            $text = $row->note_text;
            //以上為php碼 
    ?>
            <script type="text/javascript">
                postIt = {
                    id: <?php echo json_encode($id); ?>,
                    note_num: <?php echo json_encode($color); ?>,
                    note: <?php echo json_encode($text); ?>
                }
                postIts.push(postIt);
            </script>
    <?php //再接著php碼，這種寫法在混合式的php、html、JavaScript很常見的寫法，要習慣。
        }
    }
    getNoteData();
    ?>

    <script>
        <?php
        $current_user = wp_get_current_user();
        ?>
        document.getElementById("app-name-landscape").innerHTML = "<?php echo esc_html($current_user->display_name); ?>的Calendar"
        let stylesheet_directory = "<?php echo get_stylesheet_directory_uri(); ?>";

        updateDates(); //更新月曆中的日期資料 (年、月、日、週幾)

        //current 目前點擊的日期
        let currentPostItID = 0; //目前的記事ID
        let newCurrentPostIt = false; //目前的記事是否為新？即目前點選的日期尚未有任何記事資料
        let currentPostItIndex = 0; //目前的記事在postIts陣列中的位置索引

        let thisYear = today.getFullYear();
        let thisMonth = today.getMonth();
        fillInMonth(thisYear, thisMonth);


        currentColor.name = "<?php echo (setTheme()); ?>"; //json_encode將回傳的資料包裝成JSON編碼字串，然後指定給currentColor.name
        changeColor();
    </script>

</body>

</html>