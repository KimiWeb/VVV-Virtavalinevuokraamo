document.getElementById('btnLisaaHuolto').addEventListener('click', lisaaHuolto);
function lisaaHuolto()
{
    document.getElementById("txtIlmoitus").value = "Lisätään huoltotietoa.";
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää tyontekijaid -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'lisaahuolto.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    
    xhrObject.onload = function() {
    if (xhrObject.status === 200) {
      console.log('1. palattiin onnistuneesti ' + xhrObject.responseText);
      // php-koodi on suoritettu ja nyt on palattu takaisin app.js-koodiin
      // käsitellään php-koodin palauttama tieto onnistuiko lisäys
      if (xhrObject.responseText == 'OK')
      {
        console.log('2. Tietokantatoiminto onnistui ' + xhrObject.responseText);
        document.getElementById("txtIlmoitus").value = "Huolto lisätty.";
      } else 
      {
        console.log('2. Tietokantatoiminto ei onnistu ' + xhrObject.responseText);
        document.getElementById("txtIlmoitus").value = xhrObject.responseText;
      } 
    }
  }
  xhrObject.onerror = function() {
    console.error('Virhe lisäyksessä ' + url);
  };
    // lähetetään kaksi tietoa Ajax requestin datassa post.php:lle 
  let tyontekijaid = document.getElementById("txtTyontekijaid").value;
  let laiteid = document.getElementById("txtLaiteid").value;  
  let vikatyyppi = document.getElementById("txtVikatyyppi").value;
 

  xhrObject.send("tyontekijaid=" + tyontekijaid + "&laiteid=" + laiteid + "&vikatyyppi=" + vikatyyppi);
  console.log("tyontekijaid=" + tyontekijaid + "&laiteid=" + laiteid + "&vikatyyppi=" + vikatyyppi);

}
