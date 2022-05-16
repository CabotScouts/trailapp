import React from 'react';
import List from '@/layouts/admin/submission-list';

export default function Submissions({ team, submissions }) {
  return (
    <List submissions={ submissions }>{ team.name } ({ team.group })</List>
  )
}
