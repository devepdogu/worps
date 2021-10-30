<?php

require '../src/worps.php';

$files = array(["path" => "../files/bad.txt"], ["path" => "../files/empty.txt", "separator" => ","]);
$worps = new Worps($files);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        body {
            font-family: 'Montserrat', sans-serif !important;
        }

        .main {
            height: 100vh;
            background-color: #0466C8;
        }

        form {
            background-color: #023E7D;
            padding: 40px;
            border-radius: 20px;
            color: white;
            width: 35%;
            height: 90vh;
            text-align: center;
            display: flex;
            align-items: center;
            overflow: hidden;
            flex-direction: column;
        }

        h1 {
            margin: unset;
        }

        .vertical-center {
            padding-top: 5vh;
            display: flex !important;
            /* align-items: center; */
            justify-content: center;
        }

        .inputs {
            margin-top: auto;
            margin-bottom: auto;
            width: 100%;
        }

        textarea {
            resize: unset;
        }

        .badWords {

            margin-right: 20px;
            max-height: 200px;
            background-color: white;
            border-radius: 20px;
            padding: 20px;
            width: 200px;
        }

        .converterResult {

            margin-left: 20px;
            max-height: 90vh;
            background-color: white;
            border-radius: 20px;
            padding: 20px;
            width: 400px;
            display: none;
        }

        ul {
            margin-bottom: 0px;
        }

        ul li {
            margin-top: 5px;
        }

        .shownChar {
            width: 35px;
            padding: 10px;
            padding-right: 0px;
            margin-right: 8px;
            margin-top: 8px;
            height: 35px;
        }
    </style>

    <title>Hello, world!</title>
</head>

<body>

    <div class="main container-fluix vertical-center">
        <div class="badWords">
            <p>
                Bad Words List
            </p>
            <?php foreach ($worps->getAllWords() as $item) {
                foreach ($item as $words) { ?>
                    <kbd><?= $words ?></kbd>
            <?php }
            } ?>
        </div>
        <form class="converter">
            <h1 class="mb-3">Worps</h1>
            <div class="inputs">
                <textarea class="form-control form-control-lg" rows="5" name="text" required placeholder="Give me text!"></textarea>
                <div class="accordion mt-3" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Settings
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body" style="color:black">
                                <div class="container-fluid " style="text-align:left;padding:0px">
                                    <div class="row align-items-center">
                                        <div class="col-md-6 col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" name="shuffle" id="shuffle">
                                                <label class="form-check-label" for="shuffle">
                                                    Shuffle Shown Char
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label for="range" class="form-label">Shown Char Size (<b class="rangeVal">0</b>)
                                            </label>
                                            <input type="range" class="form-range" id="range" value="0" step="1" name="shortLength" max="15">
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    Shown Chars
                                                </label>
                                                <div class="shownChars d-flex" style="flex-wrap:wrap">
                                                    <input class="form-control shownChar" maxlength="1" type="text" name="char[]" autocomplete="off">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <button class="btn btn-primary mt-3 w-100" type="submit">Convert</button>
            </div>

        </form>
        <div class="converterResult">
            <h2>Results</h2>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        $('.shownChars').children().not($('.shownChars').children().first()).each((i, item) => {
            $(item).attr("disabled", true);
        })

        $("#shuffle").on("click", function() {
            if ($(this).prop("checked")) {

                $('.shownChars input').removeAttr("disabled");
            } else {
                $('.shownChars').children().not($('.shownChars').children().first()).each((i, item) => {
                    $(item).attr("disabled", true);
                })
            }
        })


        $(document.body).on("change", ".shownChar", function() {
            $(this).attr("value", $(this).val());
        })
        // <input class="form-control shownChar" maxlength="1" type="text" name="char[]" autocomplete="off">
        $('#range').on("change", function() {
            $('.rangeVal').text($(this).val());


            var $shownChars = [];
            $('.shownChars input').each((i, item) => {
                $shownChars.push($(item).val());
            });
            $('.shownChars').html(`<input class="form-control shownChar" maxlength="1" value='${$shownChars[0]}' type="text" name="char[]" autocomplete="off">`);
            for (i = 1; i < $(this).val(); i++) {
                $('.shownChars').append(`<input class="form-control shownChar"   ${!$("#shuffle").prop("checked") ? 'disabled=""' : ''} maxlength="1" type="text" name="char[]" autocomplete="off">`);

            }

        })
        $('.converter').on("submit", function(e) {
            $('.converterResult').fadeOut().find(".resultDetail").remove();
            e.preventDefault();
            if ($(this).find("textarea").val() != "") {
                $.ajax({
                    url: "http://localhost/badworps/test/convert.php",
                    type: "post",
                    data: $(this).serialize(),
                    success: function(data) {
                        var obj = JSON.parse(data);
                        if (obj) {
                            var str = "";
                            for (const [key, value] of Object.entries(obj)) {
                                if (key == "hiddenWordsGroup") {
                                    str += (`<li>${key} <ul>`);
                                    for (const [k, v] of Object.entries(obj.hiddenWordsGroup)) {
                                        str += (`<li>${k} : <strong>${v}</strong></li>`);
                                    }
                                    str += (`</ul> </li>`);
                                } else if (key == "files") {
                                    str += (`<li>${key} <ul>`);
                                    for (const [k, v] of Object.entries(obj.files)) {
                                        str += (`<li>file : ${v.path.split("/")[v.path.split("/").length - 1]}</li>`);
                                    }
                                    str += (`</ul> </li>`);
                                } else if (key == "settings") {
                                    str += (`<li>${key} <ul>`);
                                    for (const [k, v] of Object.entries(obj.settings)) {
                                        str += (`<li>${k} : ${v}</li>`);
                                    }
                                    str += (`</ul> </li>`);
                                } else
                                    str += (`<li>${key} : <strong>${value}</strong></li>`);
                            }
                            $('.converterResult').fadeIn().append(`
                            <div class="mt-2 resultDetail">
                            <ul>${str}</ul>
                            </div>
                            `);
                        }
                    }
                })
            }
        })
    </script>

</body>

</html>