const api = 'third-music.apis.colmon.fr';

function rq(type) {
  return function request(data = {}, callback) {
    if (typeof data === 'function' && !callback) {
      /* eslint-disable-next-line */
      callback = data; data = null;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', `https://${api}/?${type}`, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        let response = xhr.responseText;
        try {
          response = JSON.parse(response);
        } catch (e) {
          callback({ error: true, message: 'Can\'t parse server response' });
          return;
        }
        callback(response);
      }
    };
    xhr.send(JSON.stringify(data));
  };
}

export default {
  GET_MUSICS: rq('getMusics'),
  LOVE_MUSIC: rq('addLove'),
};
