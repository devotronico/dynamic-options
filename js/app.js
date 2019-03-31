
console.time('tempo');







let promises = [];
let selectListClass = [];
let selectListNode = [];

const queryList = ['clienti', 'fornitori', 'fatture', 'notecredito', 'parcelle', 'document'];

for (let index = 0; index < queryList.length; index++) {

    selectListClass.push(new Selectr('#mySelect-'+index, {searchable: true, width: 'auto'}));

    const selectNode = document.querySelector('#mySelect-'+index);
    selectListNode.push(selectNode);

    promises.push(getData(queryList[index]));
}




Promise.all(promises)
.then((data) =>{ console.log(data);

selectListClass.forEach( (select, index) => select.add(data[index]) );

// selectListNode.forEach( select => select.parentNode.style.display = 'block');

  console.timeEnd('tempo');
})
.catch((err) => {
  console.log(err);
});

async function getData(query) {
    let response = await fetch('server/query.php?query='+query);
    let obj = await response.json(); 
    
    return obj;
}

console.log('finito');