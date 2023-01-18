<div class="app-container">
    <h1>UserController->show($id)</h1>
    <p>Je zit nu op de show methode van de UserController</p>
    <p>Deze methode is gekoppeld aan de route: /users/{id}</p>
    <p>URL parameters verkregen:</p>
    <ul>ID: <?= $id ?></ul>
    <ul>
        <li><a href="/">Index</a></li>
        <li><a href="/users">Users->index</a></li>
        <li><a href="/users/1">Users->show(1)</a></li>
    </ul>
</div>