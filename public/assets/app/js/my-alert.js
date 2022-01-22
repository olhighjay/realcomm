function confirmDeactivation(object, id, type, url) {
  Alt.alternative({
    status:'question',
    showConfirmButton:true,
    showCancelButton:true,
    stop:true,
    title:'Are You Sure?',
    text:`You about to ${type} this ${object}`
  })
  .then((res) => {
    // Alt.alternative({
    //   status:'loading'
    // });
    if (res){
      Alt.alternative({
        status:'loading'
      });
      axios.post(`/admins/${id}/edit`, {type: type})
      .then(response => {
        console.log(response.status)
        if(response.status === 200) {
          setTimeout(() => {
            Alt.alternative({
              status:'success'
            })
          },2000);
          axios.get(url)
            .then(response => {
              return response.data;
            });
          // setTimeout(() => window.location.replace("/"), 2000);
        } else{
          setTimeout(() => {
            Alt.alternative({
              status:'error',
              title:'Server Errors',
              text:'Your request failed on server'
            })
          },200)
        }
      })
      .catch(error => {
        console.log(error.response)
        setTimeout(() => {
          Alt.alternative({
            status:'error',
            title:'Server Errors',
            text:'Your request failed on server'
          })
        },200)
      })
    }
  })
}
