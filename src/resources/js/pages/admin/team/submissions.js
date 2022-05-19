import React from 'react';
import List from '@/layouts/admin/submission-list';

export default function Submissions({ team, submissions }) {
  return (
    <List submissions={ submissions }>
      <div className="p-3">
        { team.name } ({ team.group })
      </div>
    </List>
  )
}
