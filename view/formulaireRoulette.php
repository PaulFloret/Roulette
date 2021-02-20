<form method="POST" action="index.php">
        <div class="container">
            <div id="mise">
                <label for="bet">Mise :</label>
                <input type="number" name="bet" id="bet" min="1" value="1"><br/>
                <?= $messagePF ?>
            </div>
            <div id="choix">
                <div>
                    <label for="case">Parier sur une case :</label>
                    <input name="choix" id="case" type="number" min="0" max="36"/>
                </div>
                <h2>ou</h2>
                <div>
                    <label for="paire">Paire :</label>
                    <input type="radio" name="choix" value="paire">
                    <label for="impaire">Impaire :</label>
                    <input type="radio" name="choix" value="impaire">
                </div>
            </div>
            <button name="btnJouer">Lancer la roulette</button>
        </div>
</form>