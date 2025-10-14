import React, { useState, useEffect } from "react";
import "../../css/app.css";
import "../../css/style.css";
import "../../css/match.css";

export default function Match({
    matches = [],
    existingMatches = [],
    userType = "company",
    currentUser = null,
    matchTitle = "Matches",
    matchSubtitle = "",
    totalMatches = 0,
}) {
    const [currentMatches, setCurrentMatches] = useState(matches);
    const [currentExistingMatches, setCurrentExistingMatches] =
        useState(existingMatches);
    const [activeTab, setActiveTab] = useState("discover");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchMatches();
    }, []);

    const fetchMatches = async () => {
        try {
            const response = await fetch("/match", {
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (response.ok) {
                const data = await response.json();
                setCurrentMatches(data.props.matches?.slice(0, limit) || []);
            }
        } catch (error) {
            console.error("Error fetching matches:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleLike = async (targetId) => {
        try {
            const response = await fetch("/match/create", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN":
                        document
                            .querySelector('meta[name="csrf-token"]')
                            ?.getAttribute("content") || "",
                },
                body: JSON.stringify({
                    target_id: targetId,
                }),
            });

            if (response.ok) {
                const likedMatch = currentMatches.find(
                    (match) => match.id === targetId
                );
                setCurrentMatches((prev) =>
                    prev.filter((match) => match.id !== targetId)
                );
                setCurrentExistingMatches((prev) => [
                    ...prev,
                    { ...likedMatch, match_date: new Date().toISOString() },
                ]);

                alert("Perfect match! You can now contact each other.");
            } else {
                const error = await response.json();
                alert(error.message || "Failed to create match");
            }
        } catch (error) {
            console.error("Error creating match:", error);
            alert("Failed to create match");
        }
    };

    const handleUnMatch = async (targetId) => {
        if (confirm("Are you sure you want to remove this match?")) {
            try {
                const response = await fetch("/match/remove", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN":
                            document
                                .querySelector('meta[name="csrf-token"]')
                                ?.getAttribute("content") || "",
                    },
                    body: JSON.stringify({
                        target_id: targetId,
                    }),
                });

                if (response.ok) {
                    setCurrentExistingMatches((prev) =>
                        prev.filter((match) => match.id !== targetId)
                    );
                    alert("Match removed successfully");
                } else {
                    alert("Failed to remove match");
                }
            } catch (error) {
                console.error("Error removing match:", error);
                alert("Failed to remove match");
            }
        }
    };

    const handleContact = (match) => {
        const email = match.Student_Email || match.Company_Email || match.email;
        const name = match.Student_Name || match.Company_Name || match.name;
        const subject = `Contact from ${
            currentUser?.name || "Stagemarkt User"
        }`;

        window.location.href = `mailto:${email}?subject=${encodeURIComponent(
            subject
        )}`;
    };

    const handleViewDetails = (match) => {
        if (
            match.type === "student" &&
            (match.portfolio || match.Portfolio_Link)
        ) {
            window.open(match.portfolio || match.Portfolio_Link, "_blank");
        } else {
            alert(
                `View details for ${
                    match.name || match.Student_Name || match.Company_Name
                }`
            );
        }
    };

    const renderMatchCard = (match, isExisting = false) => {
        let matchType = match.type;
        if (!matchType) {
            if (
                match.Company_Name ||
                match.Company_Email ||
                match.Company_Address ||
                match.Company_ID
            ) {
                matchType = "company";
            } else if (
                match.Student_Name ||
                match.Student_Email ||
                match.Student_ID ||
                match.Age
            ) {
                matchType = "student";
            } else {
                matchType = "unknown";
            }
        }

        return (
            <div
                key={match.id || match.Student_ID || match.Company_ID}
                className={`match-card ${matchType}`}
            >
                <h3>
                    {match.name || match.Student_Name || match.Company_Name}
                </h3>

                {matchType === "company" ? (
                    <div className="company-details">
                        <p>
                            <span className="label">Email:</span>{" "}
                            {match.email || match.Company_Email}
                        </p>
                        <p>
                            <span className="label">Adres:</span>{" "}
                            {match.address ||
                                match.Company_Address ||
                                "Not specified"}
                        </p>
                        <p>
                            <span className="label">Study:</span>{" "}
                            {match.profession || match.Profession_Name}
                        </p>
                        <p>
                            <span className="label">Field:</span>{" "}
                            {match.field || "Various"}
                        </p>
                    </div>
                ) : (
                    <div className="student-details">
                        <p>
                            <span className="label">Email:</span>{" "}
                            {match.email || match.Student_Email}
                        </p>
                        <p>
                            <span className="label">leeftijd:</span>{" "}
                            {match.age || match.Age || "Not specified"}
                        </p>
                        <p>
                            <span className="label">Study:</span>{" "}
                            {match.profession || match.Profession_Name}
                        </p>
                        <p>
                            <span className="label">School:</span>{" "}
                            {match.school || match.School_Name}
                        </p>
                        <p>
                            <span className="label">Locatie:</span>{" "}
                            {match.address || match.Address || "Not specified"}
                        </p>
                        {(match.about || match.About_Text) && (
                            <p>
                                <span className="label">Over mij:</span>{" "}
                                {(match.about || match.About_Text).substring(
                                    0,
                                    100
                                )}
                                ...
                            </p>
                        )}
                    </div>
                )}

                <div className="match-actions">
                    {!isExisting ? (
                        <>
                            <button
                                className="btn-like"
                                onClick={() => handleLike(match.id)}
                            >
                                <span className="like-icon">💖</span>
                                Like
                            </button>
                            <button
                                className="btn-secondary"
                                onClick={() => handleViewDetails(match)}
                            >
                                {matchType === "student" &&
                                (match.portfolio || match.Portfolio_Link)
                                    ? "View Portfolio"
                                    : "View Details"}
                            </button>
                        </>
                    ) : (
                        <>
                            <button
                                className="btn-contact"
                                onClick={() => handleContact(match)}
                            >
                                Contact
                            </button>
                            <button
                                className="btn-secondary"
                                onClick={() => handleViewDetails(match)}
                            >
                                {matchType === "student" &&
                                (match.portfolio || match.Portfolio_Link)
                                    ? "View Portfolio"
                                    : "View Details"}
                            </button>
                            <button
                                className="btn-unlike"
                                onClick={() =>
                                    handleUnMatch(
                                        match.id ||
                                            match.Student_ID ||
                                            match.Company_ID
                                    )
                                }
                            >
                                Verwijder Match
                            </button>
                        </>
                    )}
                </div>

                {isExisting && match.match_date && (
                    <p
                        style={{
                            fontSize: "0.8rem",
                            color: "var(--core-color)",
                            marginTop: "0.5rem",
                        }}
                    >
                        Matched:{" "}
                        {new Date(match.match_date).toLocaleDateString()}
                    </p>
                )}
            </div>
        );
    };

    return (
        <div className="match-container">
            <div className="match-header">
                <h1>{matchSubtitle}</h1>

                {/* User Profile Info */}
                {currentUser && (
                    <div className="user-profile">
                        {currentUser.profile && (
                            <p>
                                Welkom:{" "}
                                {currentUser.profile.Student_Name ||
                                    currentUser.profile.Company_Name}
                            </p>
                        )}
                    </div>
                )}

                <div className="match-tabs">
                    <button
                        className={`tab-btn ${
                            activeTab === "discover" ? "active" : ""
                        }`}
                        onClick={() => setActiveTab("discover")}
                    >
                        Ontdek ({currentMatches.length})
                    </button>
                    <button
                        className={`tab-btn ${
                            activeTab === "matches" ? "active" : ""
                        }`}
                        onClick={() => setActiveTab("matches")}
                    >
                        Mijn Matches ({currentExistingMatches.length})
                    </button>
                </div>
            </div>

            <div className="match-content">
                {activeTab === "discover" ? (
                    <>
                        <h2>
                            Ontdek nieuwe{" "}
                            {userType === "student" ? "Bedrijven" : "Studenten"}
                        </h2>
                        {loading ? (
                            <div className="loading">
                                <p>Loading opportunities...</p>
                            </div>
                        ) : currentMatches.length > 0 ? (
                            <div className="match-list">
                                {currentMatches.map((match) =>
                                    renderMatchCard(match, false)
                                )}
                            </div>
                        ) : (
                            <div className="no-matches">
                                <p>
                                    Geen Nieuwe{" "}
                                    {userType === "student"
                                        ? "bedrijven"
                                        : "studenten"}{" "}
                                    gevonden.
                                </p>
                                <p>Kom Later eens een keer terug.</p>
                            </div>
                        )}
                    </>
                ) : (
                    <>
                        <h2>Jouw Matches</h2>
                        {currentExistingMatches.length > 0 ? (
                            <div className="match-list">
                                {currentExistingMatches.map((match) =>
                                    renderMatchCard(match, true)
                                )}
                            </div>
                        ) : (
                            <div className="no-matches">
                                <p>Je hebt nog geen matches.</p>
                                <p>begin met het liken van profielen!</p>
                            </div>
                        )}
                    </>
                )}
            </div>
        </div>
    );
}
