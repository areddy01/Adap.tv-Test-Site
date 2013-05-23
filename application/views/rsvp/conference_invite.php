<script src="/js/libs/jquery-1.7.1.min.js"></script>
<script src="/js/libs/jquery.validate.min.js"></script>

<script type="text/javascript">
    $(document).ready(
        function(){
            $("#frmInvite").validate();
        }
    );
</script>

<h2 class="ucase" style="margin:40px 0 50px">This event is by invitation only</h2>

<p class="ucase i">
    If you did not receive an email invite and would like to request one, please
    submit the following information
</p>

<p class="ucase i" style="margin:30px 0">* denotes a required field</p>

<?php  $attributes = array('id' => 'frmInvite'); ?>
<?= form_open( "index.php/conference/insert", $attributes ); ?>
    <table border="0">
        <tr>
            <td>
                First Name *<br />
                <input type="text" name="first_name"  class="required" />
            </td>
            <td>
                Last Name *<br />
                <input type="text" name="last_name"  class="required" />
            </td>
        </tr>

        <tr>
            <td>
                Company *<br />
                <input type="text" name="company"  class="required" />
            </td>
            <td>
                Job Title *<br />
                <input type="text" name="job_title"  class="required" />
            </td>
        </tr>

        <tr>
            <td>
                Email *<br />
                <input type="text" name="email"  class="required email" />
            </td>
            <td style="padding-top:20px">
                <input type="submit" class="btnSubmit" value="Request an invite" />
            </td>
        </tr>
    </table>
</form>

<p class="ucase i">
    If you have any questions, please contact:<br />
    Nancy Toan  /  Phone: 650-288-0791  /  Email: <a href="emailto:nancy@adap.tv">nancy@adap.tv</a>
</p>
