import React, { useState } from 'react';
import '../../css/app.css';
import '../../css/style.css';
import '../../css/match.cs';

export default function Match({
    matches = [],
    existingMatches = [],
    userType = 'student',
    currentUser = null,
    matchTitle = 'Matches', 
    matchSubtitle = '',
    totalMatches = 0
}) {
    const [currentMatches, setCurrentMatches] = useState(matches);
    const [currentExistingMatches, setCurrentExistingMatches] = useState(existingMatches);
    const [activeTab, setActiveTab] = useState('discover');
    
    const handleUserTypeSwitch = (newUserType) => {
        window.location.href = `/match?user_type=${newUserType}&user_id=${userID}`;
    };

    const handelLike = async(targetID) => {
        try {
            const response = await fetch('/match/create', {
                method: 'POST',
                headers: {
                    'content-Type': 'applicatie/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''

                },
                body: JSON.stringify({
                    user_type: userType,
                    user_id: userId,
                    target_id: targetId
                })
            });

            if (response.ok){
                const likedMatch = currentMatches.find(match => match.id === targetId);
                setCurrentMatches(prev => prev.filter(match => match.id !== targetId));
                setCurrentExistingMatches(prev => [..prev, {...likedMatch, match_date: new Date().toISOString() }]);

                alert('Perfect match!');
            } else {
                const error = await response.json();
                alert (error.message || 'failed to create match');
            }
        } catch (error) {
            console.error('error creating match', error);
            alert('failed to create match');
        }
    };

    const handleUnMatch = async (targetId) => {
        if (confirm('Are you sure you want to remove this match?')) {
              try {
                const response = await fetch('/match/remove', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        user_type: userType,
                        user_id: userId,
                        target_id: targetId
                    })
                });

                if (response.ok) {
                    setCurrentExistingMatches(prev => prev.filter(match => match.id !== targetId));
                    alert('Match removed successfully');
                } else {
                    alert('Failed to remove match');
                }
            } catch (error) {
                console.error('Error removing match:', error);
                alert('Failed to remove match');
            }
        }
    }

    const handleContact = (match) => {
        const email = match.Student_email
    }
}   