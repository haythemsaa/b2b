@echo off
REM Script pour remplacer layouts.app par layouts.admin dans les vues admin

echo Mise a jour des layouts admin...

powershell -Command "(Get-Content 'resources\views\admin\users\create.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\users\create.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\users\edit.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\users\edit.blade.php'"

powershell -Command "(Get-Content 'resources\views\admin\groups\index.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\groups\index.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\groups\create.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\groups\create.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\groups\edit.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\groups\edit.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\groups\show.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\groups\show.blade.php'"

powershell -Command "(Get-Content 'resources\views\admin\orders\index.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\orders\index.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\orders\show.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\orders\show.blade.php'"

powershell -Command "(Get-Content 'resources\views\admin\custom-prices\index.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\custom-prices\index.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\custom-prices\create.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\custom-prices\create.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\custom-prices\edit.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\custom-prices\edit.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\custom-prices\show.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\custom-prices\show.blade.php'"

powershell -Command "(Get-Content 'resources\views\admin\returns\index.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\returns\index.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\returns\show.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\returns\show.blade.php'"

powershell -Command "(Get-Content 'resources\views\admin\messages\index.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\messages\index.blade.php'"
powershell -Command "(Get-Content 'resources\views\admin\messages\conversation.blade.php') -replace '@extends\(''layouts\.app''\)', '@extends(''layouts.admin'')' | Set-Content 'resources\views\admin\messages\conversation.blade.php'"

echo Termine!
pause
