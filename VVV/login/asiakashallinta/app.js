document.getElementById('btnHaeAsiakas').addEventListener('click', haeAsiakas);
document.getElementById('btnMuutaAsiakas').addEventListener('click', muutaSukunimi);
document.getElementById('btnPoistaAsiakas').addEventListener('click', poistaAsiakas);
document.getElementById('btnLisaaAsiakas').addEventListener('click', lisaaAsiakas);
function haeAsiakas()
{
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää atun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'haeAsiakas.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    // Haetaan asiakastunnus HTML-lomakkeelta ja lähetetään Ajax requestin datassa post.php:lle
    let Atun = document.getElementById("txtAtun").value;  
    xhrObject.send("Atun=" + Atun);    
    
  xhrObject.onload = function() {
    if (xhrObject.status === 200) {
      // vastauksessa on vain yhden henkilön nimi ("nollas")
      const JSONdataObject = JSON.parse(xhrObject.responseText);
      console.log(xhrObject.responseText);

// Serveriltä on palautettu arraytaulukko, jonka sisältö on varmasti 0-1 riviä
      if (JSONdataObject[0] != undefined )
      {
        let palautettuSukuNimi = JSONdataObject[0].sukunimi;
        document.getElementById("txtSukunimi").value = palautettuSukuNimi;
        let palautettuEtuNimi = JSONdataObject[0].etunimi;
        document.getElementById("txtEtunimi").value = palautettuEtuNimi;
        let palautettuPuhNro = JSONdataObject[0].puh_nro;
        document.getElementById("txtPuhnro").value = palautettuPuhNro;
        let palautettuLahi = JSONdataObject[0].lähiosoite;
        document.getElementById("txtLahi").value = palautettuLahi;
        let palautettuPnro = JSONdataObject[0].posti_nro;
        document.getElementById("txtPnro").value = palautettuPnro;
        let palautettuPtoim = JSONdataObject[0].postitoimipaikka;
        document.getElementById("txtPtoim").value = palautettuPtoim;
        let palautettuSposti = JSONdataObject[0].email;
        document.getElementById("txtSpost").value = palautettuSposti;
        document.getElementById("txtIlmo").value = "";

      }
      else
      {
        document.getElementById("txtSukunimi").value = "";
        document.getElementById("txtEtunimi").value = "";
        document.getElementById("txtPuhnro").value = "";
        document.getElementById("txtLahi").value = "";
        document.getElementById("txtPnro").value = "";
        document.getElementById("txtPtoim").value = "";
        document.getElementById("txtSpost").value = "";
        document.getElementById("txtIlmo").value = "Asiakasta ei löydy";
      }
    } 
  }
  xhrObject.onerror = function() {
    console.error('Virhe etsittäessä JSON tietoa osoitteesta ' + url);
  };

}

// -----

function muutaSukunimi()
{
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Atun- ja sukunimi-tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'muutaAsiakastieto.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    // Haetaan Asiakastunnus HTML-lomakkeelta ja lähetetään Ajax requestin datassa post.php:lle
    let Atun = document.getElementById("txtAtun").value;  
    let sukunimi = document.getElementById("txtSukunimi").value;  
    
    console.log("Atun=" + Atun + "&sukunimi=" + sukunimi); 
    xhrObject.send("Atun=" + Atun + "&sukunimi=" + sukunimi);    
    
  xhrObject.onload = function() {
    
    if (xhrObject.status === 200) {

      console.log(xhrObject.responseText);
      document.getElementById("txtIlmo").value = xhrObject.responseText;

    } 
  }
  xhrObject.onerror = function() {
    console.error('Virhe etsittäessä JSON tietoa osoitteesta ' + url);
  };

}

// -----

function poistaAsiakas()
{
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Atun-, etunimi ja sukunimi-tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'poistaAsiakas.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    // Haetaan asiakastunnus HTML-lomakkeelta ja lähetetään Ajax requestin datassa post.php:lle
    let Atun = document.getElementById("txtAtun").value;  
    console.log("Atun=" + Atun); 
    xhrObject.send("Atun=" + Atun);    
    
  xhrObject.onload = function() {
    if (xhrObject.status === 200) {

      console.log(xhrObject.responseText);
      document.getElementById("txtIlmo").value = xhrObject.responseText;
      document.getElementById("txtSukunimi").value = "";
      document.getElementById("txtEtunimi").value = "";

    } 
  }
  xhrObject.onerror = function() {
    console.error('Virhe etsittäessä JSON tietoa osoitteesta ' + url);
  };
}
function lisaaAsiakas()
{
    document.getElementById("txtIlmo").value = "Lisätään huoltotietoa.";
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Atun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'lisaaAsiakas.php';
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
        document.getElementById("txtIlmo").value = "Huolto lisätty.";
      } else 
      {
        console.log('2. Tietokantatoiminto ei onnistu ' + xhrObject.responseText);
        document.getElementById("txtIlmo").value = xhrObject.responseText;
      } 
    }
  }
  xhrObject.onerror = function() {
    console.error('Virhe lisäyksessä ' + url);
  };
    // lähetetään kaksi tietoa Ajax requestin datassa post.php:lle 
  let Etunimi = document.getElementById("txtEtunimi").value;  
  let Sukunimi = document.getElementById("txtSukunimi").value;  
  let Puhnro = document.getElementById("txtPuhnro").value;  
  let Lahiosoite = document.getElementById("txtLahi").value;  
  let Postinro = document.getElementById("txtPnro").value;  
  let Postitoimipaikka = document.getElementById("txtPtoim").value;  
  let Email = document.getElementById("txtSpost").value;  

  xhrObject.send("Etunimi=" + Etunimi + "&Sukunimi=" + Sukunimi + "&Puhnro=" + Puhnro + "&Lahiosoite=" + Lahiosoite + "&Postinro=" + Postinro + "&Postitoimipaikka=" + Postitoimipaikka + "&Email=" + Email);
  console.log("Etunimi=" + Etunimi + "&Sukunimi=" + Sukunimi + "&Puhnro=" + Puhnro + "&Lahiosoite=" + Lahiosoite + "&Postinro=" + Postinro + "&Postitoimipaikka=" + Postitoimipaikka + "&Email=" + Email);

}

