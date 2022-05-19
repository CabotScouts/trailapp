import React from 'react';
import List from '@/layouts/admin/submission-list';

export default function Submissions({ question, submissions }) {
  return (
    <List submissions={ submissions }>
      <div className="p-3">{ question }</div>
    </List>
  )
}
