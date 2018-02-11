<?php $title = 'Cash'; ?>
<?php include 'App/Views/components/header.php'; ?>
<script type="text/javascript" src="<?php echo HTTP ?>/js/cash.js"></script>
    <div>
        <h1>Cash drawer helper</h1>
        <p>This application will assist you in keeping track of your cash drawer and propane totals.</p>
        <p>Simply enter the number of each bill or coin into the appropriate field. The app will calculate the totals.</p>
    </div>
    <form action="/<?php echo \App\Config::SITE_NAME; ?>/modules/cash/save" method="POST">            
            <div class="col-md-2 form-group">
                <input type="hidden" id="store_id" name="store_id" value="<?php echo $user->storeNumber; ?>"
                <label for="hundreds">Hundreds</label>                
                <input type="text" id="hundreds" name="hundreds" onblur='calculateTotal();' placeholder="Hundreds" 
                   autofocus class="form-control" />
                <label for="fifties">Fifties</label>
                <input type="text" id="fifties" name="fifties" onblur='calculateTotal();' placeholder="Fifties" 
                   autofocus class="form-control" />
                <label for="twenties">Twenties</label>
                <input type="text" id="twenties" name="twenties" onblur='calculateTotal();' placeholder="Twenties" 
                   autofocus class="form-control" />
                <label for="tens">Tens</label>
                <input type="text" id="tens" name="tens" onblur='calculateTotal();' placeholder="Tens" 
                   autofocus class="form-control" />
                <label for="fives">Fives</label>
                <input type="text" id="fives" name="fives" onblur='calculateTotal();' placeholder="Fives" 
                   autofocus class="form-control" />
                <label for="ones">Ones</label>
                <input type="text" id="ones" name="ones" onblur='calculateTotal();' placeholder="Ones" 
                   autofocus class="form-control" />
                <br />
                <label for="total">Bills Total $</label>
                <input type="text" id="total" name="total" 
                       autofocus class="form-control" readonly />
                <br />                
            </div>    
            <div class="col-md-2 form-group">
                <label for="quarters">Quarters</label>
                <input type="text" id="quarters" name="quarters" onblur='calculateTotal();' placeholder="Quarters" 
                   autofocus class="form-control" />
                <label for="dimes">Dimes</label>
                <input type="text" id="dimes" name="dimes" onblur='calculateTotal();' placeholder="Dimes" 
                   autofocus class="form-control" />
                <label for="nickles">Nickles</label>
                <input type="text" id="nickles" name="nickles" onblur='calculateTotal();' placeholder="Nickles" 
                   autofocus class="form-control" />
                <label for="pennies">Pennies</label>
                <input type="text" id="pennies" name="pennies" onblur='calculateTotal();' placeholder="Pennies" 
                   autofocus class="form-control" />
                <label style="margin-top: 138px;" for="total">Coins Total $</label>
                <input type="text" id="coin_total" name="coin_total" 
                       autofocus class="form-control" readonly />

            </div> 
            <div class="col-md-2 form-group">
                    <label for="drawer">Drawer amount</label>
                    <input type="text" id="drawer" name="drawer" onblur='calculateTotal()' placeholder="Drawer" 
                       autofocus class="form-control" />
                    <br />
                    <label for="grand_total">Grand total $</label>
                    <input type="text" id="grand_total" name="grand_total" autofocus class="form-control" readonly />
                    <br />
                    <label for="cash_grand_total">Cash amount to pull:</label>
                    <input type="text" id="pull" name="pull" autofocus class="form-control" readonly />
                    <br />
            </div>
        <div class="col-md-2 form-group" style="margin-left:50px;">
                <label for="propane">Propane</label>
                <input type="text" id="propane" name="propane" placeholder="Propane" 
                   autofocus class="form-control" />
                <br />
                <label for="propane_percent">Propane Percentage</label>                
                <input type="text" id="propane_percent" name="propane_percent" placeholder="Propane Percentage" 
                   autofocus class="form-control" />
                <br />
            </div>
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <input type="submit" value="Submit" name="submit" id="btn-cash" class="btn btn-success" />
                </div>
        </form>
<?php include 'App/Views/components/footer.php'; ?>
