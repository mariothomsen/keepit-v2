export default function saveApiKeepit(raw) {
  var myHeaders = new Headers()

  myHeaders.append('Content-Type', 'application/json')
  var requestOptions = {
    method: 'POST',
    headers: myHeaders,
    body: JSON.stringify(raw),
    redirect: 'follow',
  }

  return fetch(
    'http://keepit-be.local/keepit/add',
    requestOptions
  ).then((response) => response.json())
}
