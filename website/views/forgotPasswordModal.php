<!-- Trigger/Open The Modal -->
<button id="myBtn" class="button">Wachtwoord vergeten</button>

<!-- The Modal -->
<div id="myModal" class="modal">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
          return= $correct
          method="post"
          name="forgotPassword">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>Voer uw emailadres in</h3>
            </div>
            <div class="modal-body">
                <input type="text"
                       class="middle"
                       placeholder="Voer uw email in"
                       name="forgotEmail"
                       title="Voer een email in"
                       required>
            </div>
            <div class="modal-footer">
                <div class="login_containerfault"><span><?php echo $resetErr; ?></span></div>
                <button type="submit"
                        value="reset"
                        name="submit"
                        id="frm1_submit">
                    Reset password
                </button>
            </div>
        </div>

    </form>
</div>