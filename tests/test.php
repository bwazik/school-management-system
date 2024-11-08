<?php include '../master.php'; ?>

<div class="container my-4">
    <h1 class="text-center mb-4">Conditions Assignments<br><small>(without using any PHP helper functions)</small></h1>
    <p class="p">Welcome to my PHP assignments page! Here, you will find various tasks categorized by week and
        session. Use the navigation menu to explore specific assignments.</p>

    <div class="row g-4">
        <!-- Assignment 1: Maximum Between Two Numbers -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">1 - Maximum Between Two Numbers</h5>
                    <pre><code class="php">
$x = 5;
$y = 10;

if ($x > $y) {
    echo "$x is Larger than $y";
} else {
    echo "$y is Larger than $x";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $x = 5;
                            $y = 10;
                            if ($a > $b) {
                                echo "$x is Larger than $y";
                            } else {
                                echo "$y is Larger than $x";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 2: Maximum Between Three Numbers -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">2 - Maximum Between Three Numbers</h5>
                    <pre><code class="php">
$x = 1;
$y = 2;
$z = 3;

if ($x > $y && $x > $z) {
    echo "$x is the biggest";
} elseif ($y > $z && $y > $x) {
    echo "$y is the biggest";
} else {
    echo "$z is the biggest";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $x = 1;
                            $y = 2;
                            $z = 3;
                            if ($x > $y && $x > $z) {
                                echo "$x is the biggest";
                            } elseif ($y > $z && $y > $x) {
                                echo "$y is the biggest";
                            } else {
                                echo "$z is the biggest";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 3: Check If Number is Positive, Negative, or Zero -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">3 - Check If Number is Positive, Negative, or Zero</h5>
                    <pre><code class="php">
$num = -1;

if ($num > 0) {
    echo "$num is Positive";
} elseif ($num < 0) {
    echo "$num is Negative";
} else {
    echo "$num is Zero";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $num = -1;
                            if ($num > 0) {
                                echo "$num is Positive";
                            } elseif ($num < 0) {
                                echo "$num is Negative";
                            } else {
                                echo "$num is Zero";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 4: Check If Number is Divisible by 5 and 11 -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">4 - Check If Number is Divisible by 5 and 11</h5>
                    <pre><code class="php">
$num = 55;

if ($num % 5 == 0 && $num % 11 == 0) {
    echo "$num is divisible by 5 and 11";
} else {
    echo "$num is not divisible by 5 and 11";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $num = 55;
                            if ($num % 5 == 0 && $num % 11 == 0) {
                                echo "$num is divisible by 5 and 11";
                            } else {
                                echo "$num is not divisible by 5 and 11";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 5: Check If Number is Even or Odd -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">5 - Check If Number is Even or Odd</h5>
                    <pre><code class="php">
$num = 4;

if ($num % 2 == 0) {
    echo "$num is even";
} else {
    echo "$num is odd";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $num = 4;
                            if ($num % 2 == 0) {
                                echo "$num is even";
                            } else {
                                echo "$num is odd";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 6: Check If Year is a Leap Year -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">6 - Check If Year is a Leap Year</h5>
                    <pre><code class="php">
$year = 2030;

if (($year % 4 == 0)) {
    echo "$year is a leap year";
} else {
    echo "$year is not a leap year";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                        $year = 2030;
                            if (($year % 4 == 0)) {
                                echo "$year is a leap year";
                            } else {
                                echo "$year is not a leap year";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 7: Check Whether a Character is Alphabet or Not -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">7 - Check Whether a Character is Alphabet or Not</h5>
                    <pre><code class="php">
$string = "$2dd";

if (($string >= 'a' && $string <= 'z') || ($string >= 'A' && $string <= 'Z')) {
    echo "$string is an alphabet.";
} else {
    echo "$string is not an alphabet.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $string = "$2dd";

                            if (($string >= 'a' && $string <= 'z') || ($string >= 'A' && $string <= 'Z')) {
                                echo "$string is an alphabet.";
                            } else {
                                echo "$string is not an alphabet.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 8: Check Whether an Alphabet is Vowel or Consonant -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">8 - Check Whether an Alphabet is Vowel or Consonant</h5>
                    <pre><code class="php">
$string = "z";
$vowelLetters = ['a', 'e', 'i', 'o', 'u'];

if (in_array($string, $vowelLetters)) {
    echo "$string is a vowel.";
} else {
    echo "$string is a consonant.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $string = "a";
                            $vowelLetters = ['a', 'e', 'i', 'o', 'u'];

                            if (in_array($string, $vowelLetters)) {
                                echo "$string is a vowel.";
                            } else {
                                echo "$string is a consonant.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 9: Check Whether a Character is Alphabet, Digit, or Special Character -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">9 - Check Whether a Character is Alphabet, Digit, or Special Character</h5>
                    <pre><code class="php">
$string = '@';

if (($string >= 'a' && $string <= 'z') || ($string >= 'A' && $string <= 'Z')) {
    echo "$string is an alphabet.";
} elseif ($string >= '0' && $string <= '10000000000000000') {
    echo "$string is a digit.";
} else {
    echo "$string is a special character.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $string = '@';

                            if (($string >= 'a' && $string <= 'z') || ($string >= 'A' && $string <= 'Z')) {
                                echo "$string is an alphabet.";
                            } elseif ($string >= '0' && $string <= '10000000000000000') {
                                echo "$string is a digit.";
                            } else {
                                echo "$string is a special character.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 10: Check Whether a Character is Uppercase or Lowercase Alphabet -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">10 - Check Whether a Character is Uppercase or Lowercase Alphabet</h5>
                    <pre><code class="php">
$string = "G";

if ($string >= 'a' && $string <= 'z') {
    echo "$string is a lowercase alphabet.";
} elseif ($string >= 'A' && $string <= 'Z') {
    echo "$string is an uppercase alphabet.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $string = "G";

                            if ($string >= 'a' && $string <= 'z') {
                                echo "$string is a lowercase alphabet.";

                            } elseif ($string >= 'A' && $string <= 'Z') {
                                echo "$string is an uppercase alphabet.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 11: Input Week Number and Print Week Day -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">11 - Input Week Number and Print Week Day</h5>
                    <pre><code class="php">
$weekDay = 7;

switch ($weekDay) {
    case 1:
        echo "Saturday";
        break;
    case 2:
        echo "Sunday";
        break;
    case 3:
        echo "Monday";
        break;
    case 4:
        echo "Tuesday";
        break;
    case 5:
        echo "Wednesday";
        break;
    case 6:
        echo "Thursday";
        break;
    case 7:
        echo "Friday";
        break;
    default:
        echo "Error";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $weekDay = 7;

                            switch ($weekDay) {
                                case 1:
                                    echo "Saturday";
                                    break;
                                case 2:
                                    echo "Sunday";
                                    break;
                                case 3:
                                    echo "Monday";
                                    break;
                                case 4:
                                    echo "Tuesday";
                                    break;
                                case 5:
                                    echo "Wednesday";
                                    break;
                                case 6:
                                    echo "Thursday";
                                    break;
                                case 7:
                                    echo "Friday";
                                    break;
                                default:
                                    echo "Error";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 12: Input Month Number and Print Number of Days in That Month -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">12 - Input Month Number and Print Number of Days in That Month</h5>
                    <pre><code class="php">
$monthNumber = 2;
$daysInMonth = 0;

if ($monthNumber == 2) {
    $daysInMonth = 28;
} elseif (in_array($monthNumber, [4, 6, 9, 11])) {
    $daysInMonth = 30;
} else {
    $daysInMonth = 31;
}

echo "$daysInMonth days";

                    </code></pre>
                    <p class="card-text">
                        <?php
                            $monthNumber = 2;
                            $daysInMonth = 0;

                            if ($monthNumber == 2) {
                                $daysInMonth = 28;
                            } elseif (in_array($monthNumber, [4, 6, 9, 11])) {
                                $daysInMonth = 30;
                            } else {
                                $daysInMonth = 31;
                            }

                            echo "$daysInMonth days";
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 13: Count Total Number of Notes in Given Amount -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">13 - Count Total Number of Notes in Given Amount</h5>
                    <pre><code class="php">
echo 'مليش فالرياضة والله';
                    </code></pre>
                    <p class="card-text">
                        <?php
                            echo 'مليش فالرياضة والله';
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 14: Switch Statement to Handle Different User Roles in PHP -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">14 - Switch Statement to Handle Different User Roles in PHP</h5>
                    <pre><code class="php">
$role = 'admin';

switch ($role) {
    case 'user':
        echo "Welcome, User!";
        break;
    case 'editor':
        echo "Welcome, Editor!";
        break;
    case 'admin':
        echo "Welcome, Admin!";
    default:
        echo "Error";
}

                    </code></pre>
                    <p class="card-text">
                        <?php
                            $role = 'admin';

                            switch ($role) {
                                case 'user':
                                    echo "Welcome, User!";
                                    break;
                                case 'editor':
                                    echo "Welcome, Editor!";
                                    break;
                                case 'admin':
                                    echo "Welcome, Admin!";
                                    break;
                                default:
                                    echo "Error";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 15: Using || (OR) to Check Multiple Conditions in PHP -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">15 - Using || (OR) to Check Multiple Conditions in PHP</h5>
                    <pre><code class="php">
echo 'Used in 7,9 Assignments';
                    </code></pre>
                    <p class="card-text">
                        <?php
                            echo 'Used in 7,9 Assignments';
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 16: Check Whether Angles of a Triangle Make It Valid -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">16 - Check Whether Angles of a Triangle Make It Valid</h5>
                    <pre><code class="php">
$angle1 = 60;
$angle2 = 60;
$angle3 = 50;

if ($angle1 + $angle2 + $angle3 == 180) {
    echo "The triangle is valid.";
} else {
    echo "The triangle is not valid.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $angle1 = 60;
                            $angle2 = 60;
                            $angle3 = 50;

                            if ($angle1 + $angle2 + $angle3 == 180) {
                                echo "The triangle is valid.";
                            } else {
                                echo "The triangle is not valid.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 17: Check Whether the Triangle is Equilateral, Isosceles, or Scalene -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">17 - Check Whether the Triangle is Equilateral, Isosceles, or Scalene</h5>
                    <pre><code class="php">
$side1 = 5;
$side2 = 5;
$side3 = 5;

if ($side1 == $side2 && $side2 == $side3) {
    echo "The triangle is equilateral.";
} elseif ($side1 == $side2 || $side2 == $side3 || $side1 == $side3) {
    echo "The triangle is isosceles.";
} else {
    echo "The triangle is scalene.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $side1 = 5;
                            $side2 = 5;
                            $side3 = 5;

                            if ($side1 == $side2 && $side2 == $side3) {
                                echo "The triangle is equilateral.";
                            } elseif ($side1 == $side2 || $side2 == $side3 || $side1 == $side3) {
                                echo "The triangle is isosceles.";
                            } else {
                                echo "The triangle is scalene.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 18: Find All Roots of a Quadratic Equation -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">18 - Find All Roots of a Quadratic Equation</h5>
                    <pre><code class="php">
echo 'مليش فالرياضة والله';
                    </code></pre>
                    <p class="card-text">
                        <?php
                            echo 'مليش فالرياضة والله';
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 19: Calculate Profit or Loss -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">19 - Calculate Profit or Loss</h5>
                    <pre><code class="php">
$costPrice = 2200;
$sellingPrice = 2000;
$profit = $sellingPrice - $costPrice;
$loss = $costPrice - $sellingPrice;

if ($sellingPrice > $costPrice) {
    echo "Profit: $profit";
} elseif ($sellingPrice < $costPrice) {
    echo "Loss: $loss";
} else {
    echo "No profit, no loss.";
}
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $costPrice = 2200;
                            $sellingPrice = 2000;
                            $profit = $sellingPrice - $costPrice;
                            $loss = $costPrice - $sellingPrice;

                            if ($sellingPrice > $costPrice) {
                                echo "Profit: $profit";
                            } elseif ($sellingPrice < $costPrice) {
                                echo "Loss: $loss";
                            } else {
                                echo "No profit, no loss.";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 20: Calculate Percentage and Grade Based on Marks of Five Subjects -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">20 - Calculate Percentage and Grade Based on Marks of Five Subjects</h5>
                    <pre><code class="php">
$physics = 65;
$chemistry = 70;
$biology = 62;
$mathematics = 60;
$computer = 55;

$studentMarks = $physics + $chemistry + $biology + $mathematics + $computer;
$fullMarks = 500;
$percentage = ($studentMarks / $fullMarks) * 100;

if ($percentage >= 90) {
    $grade = 'A';
} elseif ($percentage >= 80) {
    $grade = 'B';
} elseif ($percentage >= 70) {
    $grade = 'C';
} elseif ($percentage >= 60) {
    $grade = 'D';
} elseif ($percentage >= 40) {
    $grade = 'E';
} else {
    $grade = 'F';
}

echo "Percentage: $percentage%<br>Grade: $grade";

                    </code></pre>
                    <p class="card-text">
                        <?php
                            $physics = 65;
                            $chemistry = 70;
                            $biology = 62;
                            $mathematics = 60;
                            $computer = 55;

                            $studentMarks = $physics + $chemistry + $biology + $mathematics + $computer;
                            $fullMarks = 500;
                            $percentage = ($studentMarks / $fullMarks) * 100;

                            if ($percentage >= 90) {
                                $grade = 'A';
                            } elseif ($percentage >= 80) {
                                $grade = 'B';
                            } elseif ($percentage >= 70) {
                                $grade = 'C';
                            } elseif ($percentage >= 60) {
                                $grade = 'D';
                            } elseif ($percentage >= 40) {
                                $grade = 'E';
                            } else {
                                $grade = 'F';
                            }

                            echo "Percentage: $percentage%<br>Grade: $grade";
                        ?>
                    </p>
                </div>
            </div>
        </div>



    </div>

    <div class="row g-4 mt-4">
        <!-- Assignment 21: Calculate Gross Salary -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">21 - Calculate Gross Salary</h5>
                    <pre><code class="php">
$basicSalary = 13250;
$hra = 0;
$da = 0;

if ($basicSalary <= 10000) {
    $hra = ($basicSalary * 20) / 100;
    $da = ($basicSalary * 80) / 100;
} elseif ($basicSalary <= 20000) {
    $hra = ($basicSalary * 25) / 100;
    $da = ($basicSalary * 90) / 100;
} else {
    $hra = ($basicSalary * 30) / 100;
    $da = ($basicSalary * 95) / 100;
}

$grossSalary = $basicSalary + $hra + $da;
echo "Gross Salary: $grossSalary"
                    </code></pre>
                    <p class="card-text">
                        <?php
                            $basicSalary = 13250;
                            $hra = 0;
                            $da = 0;

                            if ($basicSalary <= 10000) {
                                $hra = ($basicSalary * 20) / 100;
                                $da = ($basicSalary * 80) / 100;
                            } elseif ($basicSalary <= 20000) {
                                $hra = ($basicSalary * 25) / 100;
                                $da = ($basicSalary * 90) / 100;
                            } else {
                                $hra = ($basicSalary * 30) / 100;
                                $da = ($basicSalary * 95) / 100;
                            }

                            $grossSalary = $basicSalary + $hra + $da;
                            echo "Gross Salary: $grossSalary"
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Assignment 22: Calculate Total Electricity Bill -->
        <div class="col-md-6">
            <div class="card bg-dark text-light h-100">
                <div class="card-body">
                    <h5 class="card-title">22 - Calculate Total Electricity Bill</h5>
                    <pre><code class="php">
echo "مليش فالرياضة والله"
                    </code></pre>
                    <p class="card-text">
                    <?php
                        echo "مليش فالرياضة والله"
                    ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
