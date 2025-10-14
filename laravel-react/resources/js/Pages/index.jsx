import React, { useState, useEffect } from "react";
import dataCities from "../../json/cities.json";
import Layout from "./Layout";
import HomeMatches from "./match"; // Import the HomeMatches component

export default function Index({
    // Add the same props that HomeMatches expects
    matches = [],
    existingMatches = [],
    userType = "student",
    currentUser = null,
    matchTitle = "Find Your Perfect Match",
    matchSubtitle = "Connect with companies and students for internship opportunities",
    totalMatches = 0,
}) {
    const [searchOpleiding, setSearchOpleiding] = useState("");

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search);
        const searchTerm = urlParams.get("opleiding");
        if (searchTerm) {
            setSearchOpleiding(searchTerm);
        }
    }, []);

    const handleSearch = (e) => {
        e.preventDefault();

        window.location.href = `\?opleiding=${encodeURIComponent(
            searchOpleiding
        )}`;
    };
    return (
        <Layout>
            {/* Keep the search header */}
            <div className="header-bottom">
                <div className="search-image"></div>
                <div className="search">
                    <form onSubmit={handleSearch}>
                        <div className="search-top">
                            <div className="search-section">
                                <label htmlFor="opleiding">
                                    Zoek opleiding
                                </label>
                                <br />
                                <input
                                    type="search"
                                    className="search-input"
                                    name="opleiding"
                                    value={searchOpleiding}
                                    onChange={(e) =>
                                        setSearchOpleiding(e.target.value)
                                    }
                                    placeholder="Zoek op opleiding zoals 'Software Developer', 'Grafisch Ontwerp'..."
                                />
                            </div>
                            <div className="search-section">
                                <label htmlFor="locatie">
                                    Plaats of postcode
                                </label>
                                <input
                                    type="search"
                                    className="search-input"
                                    id="input-location"
                                    name="locatie"
                                    list="locatie"
                                />
                                <datalist id="locatie">
                                    {Array.isArray(dataCities.value) &&
                                        dataCities.value.map((city) => (
                                            <option
                                                key={city.Key}
                                                value={city.Title}
                                            >
                                                {city.Title}
                                            </option>
                                        ))}
                                </datalist>
                                <select
                                    name="locatie-range"
                                    className="search-input"
                                >
                                    <option value="0">+0km</option>
                                    <option value="5">+5km</option>
                                    <option value="10">+10km</option>
                                    <option value="20">+20km</option>
                                    <option value="50">+50km</option>
                                </select>
                            </div>
                            <div className="search-section" id="search-button">
                                <button type="submit" className="search-input">
                                    Zoeken
                                </button>
                            </div>
                        </div>
                    </form>
                    <div className="search-bottom">
                        <div className="search-section">
                            <h2>Zoeken naar</h2>
                            <p>Stages</p>
                            <label className="switch">
                                <input type="checkbox" />
                                <span className="slider round"></span>
                            </label>
                            <p>Leerbedrijven</p>
                        </div>
                        <div className="search-section">
                            <h2>Land</h2>
                            <select>
                                <option value="nl">Nederland</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <HomeMatches
                matches={matches}
                existingMatches={existingMatches}
                userType={userType}
                currentUser={currentUser}
                matchTitle={matchTitle}
                matchSubtitle={matchSubtitle}
            />
        </Layout>
    );
}
