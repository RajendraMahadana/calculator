
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Simple PHP Calculator</title>
<link rel="stylesheet" href="sty.css">
</head>
<body>
    <div class="calculator">
        <form method="post">
            <div class="input-return">
                <input type="text" 
                   name="display" 
                   id="display" 
                   class="input" 
                   value="<?php echo isset($_POST['display']) ? htmlspecialchars($_POST['display']) : ''; ?>" 
                   readonly />
            <br />
        <?php
            if (isset($_POST['calculate'])) {
                $display = $_POST['display'];
                $display = str_replace('^', '**', $display);
           
                if (preg_match('/^[0-9\.\+\-\*\/\%\(\)\s\^]+$/', $display)) {
                    try {
                        $result = eval("return $display;");
                        echo "<input type='text' value='$result' id='result' readonly class='result' />";
                    } catch (ParseError $e) {
                        echo "<input type='text' value='Error' readonly class='result' />";
                    }
                }else {
                    echo "<input type='text' id='result' value='Invalid input' readonly />";
                }
            }
        ?> 
        </div>


        <?php
            $buttons = [
                ['7', '8', '9', '/'],
                ['4', '5', '6', '*'],
                ['1', '2', '3', '-'],
                ['0', '.', '=', '+'],
                ['^', '%', 'C']
            ];
            foreach ($buttons as $row) {
                foreach ($row as $button) {
                    if ($button == '=') {
                        echo '<input type="submit" name="calculate" value="=" class="equals" />';
                    } elseif ($button == 'C') {
                        echo '<input type="button" value="C" onclick="clearDisplay()" class="clear" />';
                    } else {
                        $class = in_array($button, ['/', '*', '-', '+', '^', '%']) ? 'operator' : '';
                        echo '<input type="button" value="' . $button . '" onclick="addToDisplay(\'' . $button . '\')" class="' . $class . '" />';
                    }
                }
                echo '<br/>';
            }
        ?>
        </form>
    </div>

    
    <script>
        function addToDisplay(value) {
            const display = document.getElementById('display');
            const operators = ['/', '*', '-', '+', '^', '%'];
            const lastChar = display.value.slice(-1);

            if (operators.includes(lastChar) && operators.includes(value)) {
                
                display.value = display.value.slice(0, -1) + value;
            } else {
               
                display.value += value;
            }
        }

        function clearDisplay() {
            document.getElementById('display').value = '';
            document.getElementById('result').value = '';
        }
    </script>
</body>
</html>
