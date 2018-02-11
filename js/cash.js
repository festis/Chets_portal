/*
This source is shared under the terms of LGPL 3
www.gnu.org/licenses/lgpl.html

You are free to use the code in Commercial or non-commercial projects
*/

        
function calculateTotal()
{
    // Set up the variables This will pull the current value for whatever is in
    // The form. If a field is blank it is assumed 0.
    var hundreds = document.getElementById('hundreds').value * 100;
    var fifties = document.getElementById('fifties').value * 50;
    var twenties = document.getElementById('twenties').value * 20;
    var tens = document.getElementById('tens').value * 10;
    var fives = document.getElementById('fives').value * 5;
    var ones = document.getElementById('ones').value * 1;
    var quarters = document.getElementById('quarters').value * .25;
    var dimes = document.getElementById('dimes').value * .1;
    var nickles = document.getElementById('nickles').value * .05;
    var pennies = document.getElementById('pennies').value * .01
    // Variables to hold totals
    var cashAmount = hundreds + fifties + twenties + tens + fives + ones;
    // What the crap is parseFloat??? oh, Javascript needs it to figure out what the
    // hell is going on. the toFixed function tells it how many decmial places to show
    var coinAmount = parseFloat(quarters + dimes + nickles + pennies).toFixed(2);
    var drawerAmount = document.getElementById('drawer').value;
    var grandTotal = parseFloat(+cashAmount + +coinAmount);
    //display the result
    document.getElementById('total').value=cashAmount;
    document.getElementById('coin_total').value=coinAmount;
    // Oh and what is this shit you have to add a plus sign to the variable to tell it its a number??? 
    document.getElementById('grand_total').value=grandTotal.toFixed(2);
    document.getElementById('pull').value=(+grandTotal - +drawerAmount).toFixed(2);

}