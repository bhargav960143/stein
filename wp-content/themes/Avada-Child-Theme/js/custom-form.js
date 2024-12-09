function dm(amount) {
  string = "" + amount;
  dec = string.length - string.indexOf(".");
  if (string.indexOf(".") == -1) return string + ".00";
  if (dec == 1) return string + "00";
  if (dec == 2) return string + "0";
  if (dec > 3) return string.substring(0, string.length - dec + 3);
  return string;
}

function checkAmountToPay() {
  minimumAmount = eval(document.conv.minimumDeposit.value);
  proposedAmount = eval(document.conv.amountToPay.value);
  if (proposedAmount < minimumAmount)
    document.conv.amountToPay.value = dm(minimumAmount);
}

function convCalculate() {
  Totamt = 0;

  priceSingle = eval(document.conv.priceSingle.value);
  qtySingle = eval(document.conv.qtySingle.value);
  totalSingle = priceSingle * qtySingle;
  document.conv.totalSingle.value = dm(totalSingle);
  Totamt = Totamt + eval(totalSingle);

  priceCouple = eval(document.conv.priceCouple.value);
  qtyCouple = eval(document.conv.qtyCouple.value);
  totalCouple = priceCouple * qtyCouple;
  document.conv.totalCouple.value = dm(totalCouple);
  Totamt = Totamt + totalCouple;

  priceEvent1 = eval(document.conv.priceEvent1.value);
  qtyEvent1 = eval(document.conv.qtyEvent1.value);
  totalEvent1 = priceEvent1 * qtyEvent1;
  document.conv.totalEvent1.value = dm(totalEvent1);
  Totamt = Totamt + eval(totalEvent1);

  priceEvent2 = eval(document.conv.priceEvent2.value);
  qtyEvent2 = eval(document.conv.qtyEvent2.value);
  totalEvent2 = priceEvent2 * qtyEvent2;
  document.conv.totalEvent2.value = dm(totalEvent2);
  Totamt = Totamt + eval(totalEvent2);

  priceEvent3 = eval(document.conv.priceEvent3.value);
  qtyEvent3 = eval(document.conv.qtyEvent3.value);
  totalEvent3 = priceEvent3 * qtyEvent3;
  document.conv.totalEvent3.value = dm(totalEvent3);
  Totamt = Totamt + eval(totalEvent3);

  priceEvent4 = eval(document.conv.priceEvent4.value);
  qtyEvent4 = eval(document.conv.qtyEvent4.value);
  totalEvent4 = priceEvent4 * qtyEvent4;
  document.conv.totalEvent4.value = dm(totalEvent4);
  Totamt = Totamt + eval(totalEvent4);

  priceTea = eval(document.conv.priceTea.value);
  qtyTea = eval(document.conv.qtyTea.value);
  totalTea = priceTea * qtyTea;
  document.conv.totalTea.value = dm(totalTea);
  Totamt = Totamt + eval(totalTea);

  priceFullTables = eval(document.conv.priceFullTables.value);
  qtyFullTables = eval(document.conv.qtyFullTables.value);
  totalFullTables = priceFullTables * qtyFullTables;
  document.conv.totalFullTables.value = dm(totalFullTables);
  Totamt = Totamt + eval(totalFullTables);

  priceHalfTables = eval(document.conv.priceHalfTables.value);
  qtyHalfTables = eval(document.conv.qtyHalfTables.value);
  totalHalfTables = priceHalfTables * qtyHalfTables;
  document.conv.totalHalfTables.value = dm(totalHalfTables);
  Totamt = Totamt + eval(totalHalfTables);

  priceSteins = eval(document.conv.priceSteins.value);
  qtySteins = eval(document.conv.qtySteins.value);
  totalSteins = priceSteins * qtySteins;
  document.conv.totalSteins.value = dm(totalSteins);
  Totamt = Totamt + eval(totalSteins);

  document.conv.grandTotal.value = dm(eval(Totamt));
  document.conv.minimumDeposit.value = dm(eval(Totamt / 2));
  document.conv.amountToPay.value = dm(eval(Totamt / 2));
}

function calculate() {
  QtyA = 0;
  QtyB = 0;
  QtyC = 0;
  TotA = 0;
  TotB = 0;
  TotC = 0;

  PrcA = 1.25;
  PrcB = 2.35;
  PrcC = 3.45;

  if (document.ofrm.qtyA.value > "") {
    QtyA = document.ofrm.qtyA.value;
  }
  document.ofrm.qtyA.value = eval(QtyA);

  if (document.ofrm.qtyB.value > "") {
    QtyB = document.ofrm.qtyB.value;
  }
  document.ofrm.qtyB.value = eval(QtyB);

  if (document.ofrm.qtyC.value > "") {
    QtyC = document.ofrm.qtyC.value;
  }
  document.ofrm.qtyC.value = eval(QtyC);

  TotA = QtyA * PrcA;
  document.ofrm.totalA.value = dm(eval(TotA));

  TotB = QtyB * PrcB;
  document.ofrm.totalB.value = dm(eval(TotB));

  TotC = QtyC * PrcC;
  document.ofrm.totalC.value = dm(eval(TotC));

  Totamt = eval(TotA) + eval(TotB) + eval(TotC);

  document.ofrm.GrandTotal.value = dm(eval(Totamt));
}

function validNum(theForm) {
  var checkOK = "0123456789.,";
  var checkStr = theForm.qtyA.value;
  var allValid = true;
  var validGroups = true;
  var decPoints = 0;
  var allNum = "";
  for (i = 0; i < checkStr.length; i++) {
    ch = checkStr.charAt(i);
    for (j = 0; j < checkOK.length; j++) if (ch == checkOK.charAt(j)) break;
    if (j == checkOK.length) {
      allValid = false;
      break;
    }
    if (ch == ".") {
      allNum += ".";
      decPoints++;
    } else if (ch == "," && decPoints != 0) {
      validGroups = false;
      break;
    } else if (ch != ",") allNum += ch;
  }
  if (!allValid) {
    alert(
      'Please enter only numeric characters in the "Class A quantity" field.',
    );
    theForm.qtyA.focus();
    return false;
  }

  if (decPoints > 1 || !validGroups) {
    alert('Please enter a valid number in the "Class A quantity" field.');
    theForm.qtyA.focus();
    return false;
  }

  var checkOK = "0123456789.,";
  var checkStr = theForm.qtyB.value;
  var allValid = true;
  var validGroups = true;
  var decPoints = 0;
  var allNum = "";
  for (i = 0; i < checkStr.length; i++) {
    ch = checkStr.charAt(i);
    for (j = 0; j < checkOK.length; j++) if (ch == checkOK.charAt(j)) break;
    if (j == checkOK.length) {
      allValid = false;
      break;
    }
    if (ch == ".") {
      allNum += ".";
      decPoints++;
    } else if (ch == "," && decPoints != 0) {
      validGroups = false;
      break;
    } else if (ch != ",") allNum += ch;
  }
  if (!allValid) {
    alert(
      'Please enter only numeric characters in the "Class B quantity" field.',
    );
    theForm.qtyB.focus();
    return false;
  }

  if (decPoints > 1 || !validGroups) {
    alert('Please enter a valid number in the "Class B quantity" field.');
    theForm.qtyA.focus();
    return false;
  }

  var checkOK = "0123456789.,";
  var checkStr = theForm.qtyC.value;
  var allValid = true;
  var validGroups = true;
  var decPoints = 0;
  var allNum = "";
  for (i = 0; i < checkStr.length; i++) {
    ch = checkStr.charAt(i);
    for (j = 0; j < checkOK.length; j++) if (ch == checkOK.charAt(j)) break;
    if (j == checkOK.length) {
      allValid = false;
      break;
    }
    if (ch == ".") {
      allNum += ".";
      decPoints++;
    } else if (ch == "," && decPoints != 0) {
      validGroups = false;
      break;
    } else if (ch != ",") allNum += ch;
  }
  if (!allValid) {
    alert(
      'Please enter only numeric characters in the "Class C quantity" field.',
    );
    theForm.qtyC.focus();
    return false;
  }

  if (decPoints > 1 || !validGroups) {
    alert('Please enter a valid number in the "Class C quantity" field.');
    theForm.qtyC.focus();
    return false;
  }

  calculate();
  return true;
}
