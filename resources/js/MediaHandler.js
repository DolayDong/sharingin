export default class MediaHandler {
    mintaAkses(){
        return new Promise((resolve, reject) => {
            navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            }).then((stream) => {
                resolve(stream);
            }).catch((error) => {
                throw new Error(`Harap mengaktifkan ijin untuk akses media anda:  Error : ${error}`)
            });
        });
    }
}