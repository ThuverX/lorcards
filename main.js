let cards = []

fetch('http://localhost/lorcards/cards/set2-en_us.json').then(async (res) => {
    cards = await res.json()
    for(let i = 0; i < cards.length;i++){
        if(i >= 100) cards.splice(i)
    }

    cards = cards.sort((a,b) => a.regionRef.localeCompare(b.regionRef))

    if(cards_ready)
        cards_ready()
})

function addOrRemoveCard(cardid,reload = false) {
    fetch('http://localhost/lorcards/addcard.php?card=' + cardid).then(() => {
        if(reload) {
            location.reload()
        }
    })
}