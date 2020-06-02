export function getRepLogs() {
    return fetch('/api/coins')
        .then(response => {
            return response.json().then((data) => data['hydra:member']);
        });
}
export function getLastFlow(id) {
    console.log(id);
    return fetch(`/api/flows?coin=${id}`)
        .then(response => {
            return response.json().then((data) => data['hydra:member']);
        });

}