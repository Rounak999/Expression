<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target = $_SESSION['target'] ?? 0;
    $expression = $_POST['expression'] ?? '';

    // 🔒 Block dangerous PHP functions
    $forbiddenphpfunctions = array(
        "exec", "passthru", "shell_exec", "system", "proc_open", "popen", "eval", "join",
        "dol_eval", "executeCLI", "verifCond", "base64_decode", "fopen", "file_put_contents", 
        "fputs", "fputscsv", "fwrite", "fpassthru", "require", "include", "mkdir", "strip_tags",
        "substr", "strtolower", "strrev", "get_defined_functions", "rmdir", "symlink", "touch",
        "unlink", "umask", "call_user_func", "str_rot13", "hex2bin", "urldecode", "rawurldecode", 
        "gzdecode", "str_replace", "implode" 
    );

    if (strpos($expression, "::") !== false) {
        $message = "❌ Invalid input detected! No static method calls allowed.";
        $resultType = "error";
        include('result_template.php');
        exit;
    }
 
    foreach ($forbiddenphpfunctions as $badfunc) {
        if (stripos($expression, $badfunc) !== false) {
            $message = "🚫 Hacking attempt detected! Forbidden function used.";
            $resultType = "error";
            include('result_template.php');
            exit;
        }
    }

    // ✅ Safe eval execution
    try {
        $result = eval("return $expression;");
        if ($result === $target) {
            $message = "✅ Congratulations! You cracked the code! 🎯";
            $resultType = "success";
        } else {
            $message = "❌ Incorrect! The result was $result.";
            $resultType = "error";
        }
    } catch (Exception $e) {
        $message = "⚠️ Error in your expression.";
        $resultType = "error";
    }

    include('result_template.php');
} else {
    header('Location: index.php');
    exit();
}
