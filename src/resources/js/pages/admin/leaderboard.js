import React from 'react';
import Frame from '@/layouts/admin/frame';
import List from '@/layouts/admin/team-list';

export default function TeamList({ teams }) {
  return (
    <List title="Leaderboard" teams={ teams } simple />
  )
}
