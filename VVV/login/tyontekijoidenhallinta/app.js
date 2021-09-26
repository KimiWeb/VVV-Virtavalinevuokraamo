document.getElementById('btnHaeTyontekija').addEventListener('click', haeTyontekija);
document.getElementById('btnMuutaTyontekija').addEventListener('click', muutaTyontekijaSukunimi);
document.getElementById('btnPoistaTyontekija').addEventListener('click', poistaTyontekija);
document.getElementById('btnLisaaTyontekija').addEventListener('click', lisaaTyontekija);
function haeTyontekija()
{
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Ttun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'haeTyontekija.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    // Haetaan työntekijätunnus HTML-lomakkeelta ja lähetetään Ajax requestin datassa post.php:lle
    let Ttun = document.getElementById("txtTtun").value;  
    xhrObject.send("Ttun=" + Ttun);    
    
  xhrObject.onload = function() {
    if (xhrObject.status === 200) {
      // vastauksessa on vain yhden henkilön nimi ("nollas")
      const JSONdataObject = JSON.parse(xhrObject.responseText);
      console.log(xhrObject.responseText);

// Serveriltä on palautettu arraytaulukko, jonka sisältö on varmasti 0-1 riviä
      if (JSONdataObject[0] != undefined )
      {
        let palautettuTyotunnus = JSONdataObject[0].TyöntekijäID;
        document.getElementById("txtTtun").value = palautettuTyotunnus; 
        let palautettuSukuNimi = JSONdataObject[0].Sukunimi;
        document.getElementById("txtSukunimi").value = palautettuSukuNimi;
        let palautettuEtuNimi = JSONdataObject[0].Etunimi;
        document.getElementById("txtEtunimi").value = palautettuEtuNimi;
        let palautettuPuhNro = JSONdataObject[0].Puhelin;
        document.getElementById("txtPuhnro").value = palautettuPuhNro;
        let palautettuLahi = JSONdataObject[0].Lähiosoite;
        document.getElementById("txtLahi").value = palautettuLahi;
        let palautettuPnro = JSONdataObject[0].Posti_nro;
        document.getElementById("txtPnro").value = palautettuPnro;
        let palautettuPtoim = JSONdataObject[0].Postitoimipaikka;
        document.getElementById("txtPtoim").value = palautettuPtoim;
        let palautettuSposti = JSONdataObject[0].Sähköposti;
        document.getElementById("txtSpost").value = palautettuSposti;
        document.getElementById("txtIlmo").value = "";

      }
      else
      {
        document.getElementById("txtTtun").value = "";
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

function muutaTyontekijaSukunimi()
{
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Ttun- ja sukunimi-tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'muutaTyontekija.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    // Haetaan tyontekijaid HTML-lomakkeelta ja lähetetään Ajax requestin datassa post.php:lle
    let Ttun = document.getElementById("txtTtun").value;  
    let sukunimi = document.getElementById("txtSukunimi").value;  
    
    console.log("Ttun=" + Ttun + "&sukunimi=" + sukunimi); 
    xhrObject.send("Ttun=" + Ttun + "&sukunimi=" + sukunimi);    
    
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

function poistaTyontekija()
{
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Ttun-, etunimi ja sukunimi-tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'poistaTyontekija.php';
    xhrObject.open('POST', url, true);
    
    xhrObject.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    // Haetaan henkilötunnus HTML-lomakkeelta ja lähetetään Ajax requestin datassa post.php:lle
    let Ttun = document.getElementById("txtTtun").value;  
    console.log("Ttun=" + Ttun); 
    xhrObject.send("Ttun=" + Ttun);    
    
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
function lisaaTyontekija()
{
    document.getElementById("txtIlmo").value = "Lisätään huoltotietoa.";
      // Ajax-kutsu kohdistuu ohjelmaan post.php ja lähettää Ttun -tiedon php-koodille send-metodilla
    const xhrObject = new XMLHttpRequest();
    let url = 'lisaaTyontekija.php';
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
  let Ttun= document.getElementById("txtLisaaT").value;  
  let Etunimi = document.getElementById("txtEtunimi").value;  
  let Sukunimi = document.getElementById("txtSukunimi").value;  
  let Puhnro = document.getElementById("txtPuhnro").value;  
  let Lahiosoite = document.getElementById("txtLahi").value;  
  let Postinro = document.getElementById("txtPnro").value;  
  let Postitoimipaikka = document.getElementById("txtPtoim").value;  
  let Email = document.getElementById("txtSpost").value;  

  xhrObject.send("Ttun=" + Ttun + "&Etunimi=" + Etunimi + "&Sukunimi=" + Sukunimi + "&Puhnro=" + Puhnro + "&Lahiosoite=" + Lahiosoite + "&Postinro=" + Postinro + "&Postitoimipaikka=" + Postitoimipaikka + "&Email=" + Email);
  console.log("Ttun=" + Ttun + "&Etunimi=" + Etunimi + "&Sukunimi=" + Sukunimi + "&Puhnro=" + Puhnro + "&Lahiosoite=" + Lahiosoite + "&Postinro=" + Postinro + "&Postitoimipaikka=" + Postitoimipaikka + "&Email=" + Email);

}

