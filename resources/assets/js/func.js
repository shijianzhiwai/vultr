
export async function getIpData() {
    try {
        const response = await window.axios.get('/api/vultr/ips');
        return response.data.data;
    } catch (error) {
        console.log(error);
        return {};
    }
}