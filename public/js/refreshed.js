// refreshed object with settings is made available via wordpress wp_localize_script
(async () => {
    const fetchLatestModified = async () => {
        const { data, status } = await (await fetch(refreshed.url)).json();
        if (status !== 200)
            throw new Error("Refreshed: Failed to fetch status");
        return data.latest;
    };

    let latestModifiedLocal = await fetchLatestModified();

    const refreshInterval = setInterval(async () => {
        try {
            const latestModified = await fetchLatestModified();
            if (latestModified !== latestModifiedLocal) {
                window.location.reload();
            }
        } catch {
            clearInterval(refreshInterval);
        }
    }, refreshed.interval);
})();
