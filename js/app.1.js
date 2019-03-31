
console.time('tempo');



let promises = [];
let selectListClass = [];
let selectListNode = [];
// let selects = [];

(function (){
    const selects = document.querySelectorAll('.select-xhr');
    for (select of selects) {
      select.style.display = 'none';
        selectListNode.push(select);
        selectListClass.push(new Selectr( '#'+select.id, {
          searchable: true, 
          width: 'auto',
          placeholder: "Seleziona qualcosa",
          clearable: true
        }));
        promises.push(getData());
    }
})()

// for (let index = 0; index < 10; index++) {
//     selects.push(new Selectr('#mySelect-'+index, {searchable: true, width: 250}));
//     promises.push(getData(index));
// }




Promise.all(promises)
.then((res) =>{


 selectListClass.forEach( select => {
     select.add(res);
    });

    selectListNode.forEach( select => { console.log('OK');
      select.parentNode.style.display = 'block';
    });

  console.timeEnd('tempo');
})
.catch((err) => {
  console.log(err);

});

async function getData() {
    let response = await fetch('server/query.php');
    let obj = await response.json();
    return obj;
}

console.log('finito');